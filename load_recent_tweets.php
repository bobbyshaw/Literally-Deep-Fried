<?php

require('config.php');
mysql_connect($server, $username, $password) or die (mysql_error());
mysql_select_db($database) or die (mysql_error());

date_default_timezone_set('Europe/Dublin');

// First see how many tweets we're going to return
if (isset($_GET['next'])) {
    $limit = mysql_real_escape_string($_GET['next']);
} else {
    $limit = 10;
}

// Then see what tweets to load.
if (isset($_GET['bookmark'])) {
    $latest_tweet = mysql_real_escape_string($_GET['bookmark']);

    $query = "SELECT * from tweets WHERE id > '$latest_tweet' order by id asc limit $limit;";

    $result = mysql_query($query) or die (mysql_error());

    while($tweet = mysql_fetch_array($result)) {
        echo "<div class=\"tweet\"><img src=\"" . $tweet['image'] . "\" alt=\"" . $tweet['name'] . "\" title=\"" . $tweet['name'] . "\" /><a class=\"name\" href=\"http://twitter.com/" . $tweet['screen_name'] . "\">" . $tweet['name'] . "</a><p>" . $tweet['text'] . "</p><p class=\"meta-info\"><a class=\"time\" href=\"http://twitter.com/" . $tweet['screen_name'] . "/status/" . $tweet['id'] . "\">" . date("D j M Y - G:H", strtotime($tweet['time'])) . "</a>" . $tweet['source'] . "</div>";
    }

    echo "<p>Next $limit tweets since $latest_tweet</p>";

} else {
    // Get latest tweets

    $query = "SELECT * from tweets order by time desc limit $limit;";

    $result = mysql_query($query) or die (mysql_error());

    while($tweet = mysql_fetch_array($result)) {
        echo "<div class=\"tweet\"><img src=\"" . $tweet['image'] . "\" alt=\"" . $tweet['name'] . "\" title=\"" . $tweet['name'] . "\" /><a class=\"name\" href=\"http://twitter.com/" . $tweet['screen_name'] . "\">" . $tweet['name'] . "</a><p>" . $tweet['text'] . "</p><p class=\"meta-info\"><a class=\"time\" href=\"http://twitter.com/" . $tweet['screen_name'] . "/status/" . $tweet['id'] . "\">" . date("D j M Y - G:H", strtotime($tweet['time'])) . "</a>"
 . $tweet['source'] . "</div>";
    }


    echo "<p>Most recent $limit</p>";
}
?>
