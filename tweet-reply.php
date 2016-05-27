<?php

// Retrieve tweet replies from 'TweetCollect' database and reply to Twitter users stored in the database.
// TweetReplies created and added manually. 'tweets' collected via search in 'collect-tweets.php'.
// error_reporting(-1); // For debugging.

/* Connect to the database */
include 'db-conn-TC.php';
// $mysqli = new mysqli("SERVER", "USERNAME", "PASSWORD", "YOURDB");
$mysqli = new mysqli("$server","$user","$pass","$database");
if ($mysqli->connect_errno) {
exit();
}

/* Set the DB charset to utf8 */
$mysqli->query("SET CHARACTER SET utf8");
/* Setup the Twitter API */
ini_set('display_errors', 1);
require_once('TwitterAPIExchange.php'); // Twitter API

// ++++++++++++++++++++++++ RANDOM USER... +++++++++++++++++
// ====== randomly choose user to tweet as: (3 different twitter accounts. Set up app for each) =====
$input = array("pablowright", "antirobot", "catslappy");
$randomized = array_rand($input, 3);
shuffle($randomized);
$setter_user = $input[$randomized[0]];
$filename = "{$setter_user}.php" ;
include $filename ;

//==============================================================

$settings = array(
'oauth_access_token' => "$access_key",
'oauth_access_token_secret' => "$access_secret",
'consumer_key' => "$consumer_key",
'consumer_secret' => "$consumer_secret"
);

// =========== Get something to tweet: ==========================

// ++++++++++++Get tweets frome db function ++++++++++++
// $search_key = 5; // Now $tweet_key
$link = mysqli_connect("$server","$user","$pass","$database") or die("Error " . mysqli_error($link));
$query2 = "SELECT tweet FROM Tweet_Replies where search_key='$tweet_key' ORDER by RAND() LIMIT 0,50" or die("Error in the consult.." . mysqli_error($link));

$result = mysqli_query($link, $query2);
// DEBUG:
if($result === FALSE) { 
        echo mysqli_error();
}
else {

function gettxt(){
        global $link, $query2; 
        $rValue = "";
        $result = mysqli_query($link, $query2);
        if ($row = mysqli_fetch_array($result)){
            $rValue = $row['tweet'];
        }
    return $rValue;
    }
// ++++++++++++ end function +++++++++++++++++++++++
// ================================================================
}

/* Set up the Twitter API */
$url = 'https://api.twitter.com/1.1/statuses/update.json';
$requestMethod = 'POST';
/* Get the tweets from the database */
$query = $mysqli->prepare("SELECT tweetID, id_str, screen_name FROM tweets WHERE sent = 0 AND search_key = '$tweet_key' ORDER BY tweetID LIMIT 4") or trigger_error(mysqli_error($mysqli).`$query`);
$query->execute();
$query->bind_result($tweetID, $id_str, $screen_name);
while ($query->fetch()) {
// The reply: 
$reply = gettxt();
// Reply to the tweet:
$postfields = array(
'status' => '@' . $screen_name . ' ' . $reply, // Important to include the screen_name
'in_reply_to_status_id' => $id_str
);
$twitter = new TwitterAPIExchange($settings);
$twitter->buildOauth($url, $requestMethod)
->setPostfields($postfields)
->performRequest();
// Collect tweet ID's in an array:
$tweets[] = $tweetID;
}
// Update the current record with sent equals 1:
foreach ($tweets as $tweet) {
$update = $mysqli->prepare("UPDATE tweets SET sent = 1 WHERE tweetID = '$tweet'");
$update->execute();
}
/* Free the result */
$update->close();
$query->close();
/* Close the connection */
$mysqli->close();

?>