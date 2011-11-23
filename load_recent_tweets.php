<?php

require('config.php');
require('func.php');

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

    $query = "SELECT * from tweets WHERE id > '$latest_tweet' order by id desc limit $limit;";

    $result = mysql_query($query) or die (mysql_error());

    while($tweet = mysql_fetch_array($result)) {
        // Add markup to tweet where necessary, e.g. links
        $text = preg_replace( '/(?<!S)((http(s?):\/\/)|(www.))+([\w.1-9\&=#?\-~%;\/]+)/',
                '<a href="http$3://$4$5">http$3://$4$5</a>', $tweet['text']);

        // Fuzzy-fy the time
        $time = fuzzy_time($tweet['time']);

        echo <<<END
        <div id="$tweet[id]" class="tweet">
            <img src="$tweet[image]" alt="$tweet[name]" title="$tweet[name]" />
            <div class="tweet-content">
                <a class="name" href="http://twitter.com/$tweet[screen_name]">$tweet[name]</a>
                <p>$text</p>
                <p class="meta-info"><a class="time"
                        href="http://twitter.com/$tweet[screen_name]/status/$tweet[id]">$time</a></p>
            </div>
        </div>
END;
    }

} else {
    // Get latest tweets

    $query = "SELECT * from tweets order by id desc limit $limit;";

    $result = mysql_query($query) or die (mysql_error());

    while($tweet = mysql_fetch_array($result)) {
        // Add markup to tweet where necessary, e.g. links
        $text = preg_replace(
        '/(?<!S)((http(s?):\/\/)|(www.))+([\w.1-9\&=#?\-~%;\/]+)/',
        '<a href="http$3://$4$5">http$3://$4$5</a>', $tweet['text']);
        
        // Fuzzy-fy the time
        $time = fuzzy_time($tweet['time']);

        echo <<<END
        <div id="$tweet[id]" class="tweet">
            <img src="$tweet[image]" alt="$tweet[name]" title="$tweet[name]" />
            <div class="tweet-content">
                <a class="name" href="http://twitter.com/$tweet[screen_name]">$tweet[name]</a>
                <p>$text</p>
                <p class="meta-info"><a class="time"
                    href="http://twitter.com/$tweet[screen_name]/status/$tweet[id]">$time</a></p>
            </div>
        </div>
END;

}

}
?>
