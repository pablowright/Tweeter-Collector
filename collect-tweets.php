<?php
// Search for tweets based on keywords. Store them in the 'TweetCollect' database.
// Arguments passed from 'collect-loop.php'.

$userID = $_GET['USER'];
$srch = ( isset( $_GET['KEY'] ) && is_numeric( $_GET['KEY'] ) ) ? intval( $_GET['KEY'] ) : 0;
if ( $srch != 0 ){
    // id is an int != 0
$search_key = $srch;
}
else {
error_log('User does not exist '.$id. "\n", 3, "tweeterErrors.log"); 
  exit("No user by this id. Let's go listen to Science Friday.");
}

echo $userID;

// ====== Get tweets and store them in a database. PRW 05-2016. =====
// ====== Step 1. randomly choose user to tweet as: (now passed from getter-loop.php) ===============

$addtxt = ".php";
$filename = "{$userID}{$addtxt}" ;

include $filename ;

// ==================================================================
// Connect to the database //
include 'db-conn-TC.php';
$mysqli = new mysqli("$server","$user","$pass","$database"); //REPLACE vars from file
if ($mysqli->connect_errno) {
exit();
}
/* Set the DB charset to utf8 */
$mysqli->query("SET CHARACTER SET utf8");
/* Setup the Twitter API */
ini_set('display_errors', 1);
require_once('TwitterAPIExchange.php'); // Twitter API

// ++++++++++++++++++++++++ Get Twitter Credentials: ++++++++++++
// included in $filename file (above):
$settings = array(
'oauth_access_token' => "$access_key",
'oauth_access_token_secret' => "$access_secret",
'consumer_key' => "$consumer_key",
'consumer_secret' => "$consumer_secret"
);

// =================== STEP 2. Get search string from DB: ===================

// include 'db-conn-TC.php';
$link = mysqli_connect("$server","$user","$pass","$database") or die("Error " . mysqli_error($link));

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

/* change character set to utf8 */

if (!mysqli_set_charset($link, "utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($link));
 } else {
     printf("Current character set: %s\n", mysqli_character_set_name($link));
 }

// ++++++++++ Query the db to get twitter replys: ++++++++++++++
$query1 = "SELECT string FROM Search_String where search_key='$search_key' " or die("Error in the consult.." . mysqli_error($link));
if (!$query1) { // add this check.
   
    die('Invalid query: ' . mysql_error());
    }

// ================ Step 3. Search Twitter using search string from db: =======

/* Twitter API version 1.1 and the endpoint search */
$url = 'https://api.twitter.com/1.1/search/tweets.json';
// Some test searches: Now pulled from database:
// $getfield = '?q=#robot-filter:retweets&OR#postcapitalism-filter:retweets&lang=en&count=100';
//  $getfield = '?q=#robot+OR+#capitalism-filter:retweets&lang=en&count=100';
// $getfield = '?q=#AbstractArt+OR+#AbstractPainting+OR+#abstract-filter:retweets&lang=en&count=100';

$result = mysqli_query($link, $query1);
while($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
     $getfield = $row['string'];
 }
echo $getfield;

$requestMethod = 'GET';

// +++++++++++++++++++++++++++++++++++
// Get tweets with the keywords from the database: 
$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest();
$tweets = json_decode($response);

// ============= Step 4. Put Results into DB: ==============
/* Insert each tweet into the database (prepared statement) */
foreach ($tweets->statuses as $tweet) {

$query = $mysqli->prepare("INSERT INTO tweets (id_str, screen_name, tweet, search_key) VALUES (?, ?, ?, ?)")  or trigger_error(mysqli_error($mysqli).`$query`);
$query->bind_param("sssi", $tweet->id_str, $tweet->user->screen_name, $tweet->text, $search_key);
$query->execute();
$query->close();
}
/* Delete duplicate screen names. Save the latest tweet. */
$query = $mysqli->prepare("DELETE n1 FROM tweets n1, tweets n2 WHERE n1.tweetID > n2.tweetID AND n1.screen_name = n2.screen_name");
$query->execute();
$query->close();

/* Close the connection */
$mysqli->close();
 
?>