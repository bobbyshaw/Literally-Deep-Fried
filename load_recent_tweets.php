<?php

require_once('config.php');
require_once('func.php');

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
if (isset($_GET['bookmark']) && is_numeric($_GET['bookmark'])) {
    $latest_tweet = mysql_real_escape_string($_GET['bookmark']);

    $query = "SELECT * from tweets WHERE id > '$latest_tweet' order by id desc limit $limit;";
    $result = mysql_query($query) or die (mysql_error());

    while($tweet = mysql_fetch_array($result)) {
        echo toHtml($tweet);
    }

} else {
    // Get latest tweets

    $query = "SELECT * from tweets order by id desc limit $limit;";
    $result = mysql_query($query) or die (mysql_error());

    while($tweet = mysql_fetch_array($result)) {
        echo toHtml($tweet);
    }

}

?>
