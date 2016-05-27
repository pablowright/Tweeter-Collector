<?php

// Perform searches for tweets, stores them in the database. This script loops through each user and their search keys and
// sends the results to the php script 'collect-tweets.php' via curl.
// ===============================================================================================================
// To keep the database from getting too large, we purge old records (presently set to records older than 6 hours.):

// First, get db credentials from file db-conn-TC.php (TC = "Tweet Collect"):
include 'db-conn-TC.php';
// Connect to DB:
$link = mysqli_connect("$server","$user","$pass","$database") or die("Error " . mysqli_error($link));
$query = "DELETE FROM tweets WHERE timestamp < (NOW() - INTERVAL 6 HOUR) "  or die("Error in the consult.." . mysqli_error($link));
echo "<p>";
mysqli_query($link, $query);
printf("Deleted records:  %d\n", $link->affected_rows);

echo "<p>" ;

// Close the DB connection:
mysqli_close($link);

// Pause for a moment....
echo "Pause....";
sleep(1);

// Now loop through users/search keys to get fresh tweets: 
for ($n = 1; $n <= 3; $n++) {
 
       // create curl resource 
        
        $ch = curl_init();  

        // set url 
        curl_setopt($ch, CURLOPT_URL, "anti-robot.org/tweetbots/Fav-Reply/collect-tweets.php?USER=pablowright&KEY=$n"); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 
        echo $output;

        // close curl resource to free up system resources 
        curl_close($ch); 
        
        sleep(5); 
        echo '<p>';
        echo $n.'<p>';

}

// ===============================================================================

for ($n = 4; $n <= 6; $n++) {
 
       // create curl resource 
        
        $ch = curl_init();  

        // set url 
        curl_setopt($ch, CURLOPT_URL, "anti-robot.org/tweetbots/Fav-Reply/collect-tweets.php?USER=antirobot&KEY=$n"); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 
        echo $output;

        // close curl resource to free up system resources 
        curl_close($ch); 
        
        sleep(5); 
        echo '<p>';
        echo $n.'<p>';

}

// ================================================================

for ($n = 7; $n <= 8; $n++) {
 
       // create curl resource 
        
        $ch = curl_init();  

        // set url 
        curl_setopt($ch, CURLOPT_URL, "anti-robot.org/tweetbots/Fav-Reply/collect-tweets.php?USER=antirobot&KEY=$n"); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 
        echo $output;

        // close curl resource to free up system resources 
        curl_close($ch); 
        
        sleep(5); 
        echo '<p>';
        echo $n.'<p>';
        
}

?>