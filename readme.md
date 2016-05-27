Tweeter-Collector (Twitter App): PHP program to collect tweets into a SQL database then reply to the stored tweets.
- Supports multiple Twitter users, multiple searches, multiple replies. Pretty much only limited by how many
twitter apps you wish to create, etc.

Requires "TwitterAPIExchange.php" (get it here: https://github.com/J7mbo/twitter-api-php/blob/master/TwitterAPIExchange.php)

You will need:

-Twitter account with an application set up. - Provides application keys. (plenty of tutorials available on line)
-server with PHP -Hosted accounts work just fine.
-cron
-mySQL database 

Use the tweetcollect.sql file to create your database.
Download and place the TwitterAPIExchange.php somewhere your php scripts can access it.
Unpack the php files wherever works best for you.
Edit catslappy.php (and perhaps rename it to something that makes sense to you) with your Twitter app credentials
Edit db-conn-TC.php. Put in your database credentials.
Add a search string and search_key (examples in the collect-tweets.php file).
Run collect-loop.php to collect some tweets. - easiest to do this from a browser.
Add some replies to the Tweet_Replies table.
Run tweet-reply.php and check your twitter "tweets and replies".
Satisfied? set cron job to collect tweets at your pleasure.
Set another cron job to reply to tweets using tweet-reply.php.
Email me and let me know where you are running the program.

Keep in mind that too many annoying replies may aggravate people.
