<?php

    require('config.php');
    mysql_connect($server, $username, $password) or die (mysql_error());
    mysql_select_db($database) or die (mysql_error());

    set_time_limit(0);

    date_default_timezone_set('Europe/Dublin');

    $query_data = array('track' => 'literally');
    $user = 'tooliteral'; // replace with your account
    $pass = 'grammarnazi'; // replace with your account
 
    $fp = fsockopen("ssl://stream.twitter.com", 443, $errno, $errstr, 30);
    if(!$fp){
        print "$errstr ($errno)\n";
    } else {
        $request = "GET /1/statuses/filter.json?" . http_build_query($query_data) . " HTTP/1.1\r\n";
        $request .= "Host: stream.twitter.com\r\n";
        $request .= "Authorization: Basic " . base64_encode($user . ':' . $pass) . "\r\n\r\n";
        fwrite($fp, $request);
        while(!feof($fp)){
            $json = fgets($fp);
            $tweet = json_decode($json, true);
            if($tweet && $tweet['text']){
                $query = "INSERT INTO tweets 
                        VALUES ('" . 
                            $tweet['id_str'] . "', '" . 
                            $tweet['user']['screen_name'] . "', '" .
                            mysql_real_escape_string($tweet['user']['name']) . "', '" . 
                            mysql_real_escape_string($tweet['text']) . "', '" . 
                            mysql_real_escape_string($tweet['source']) . "', '" . 
                            $tweet['user']['profile_image_url'] . "', FROM_UNIXTIME('" . 
                            strtotime($tweet['created_at']) . "'));";
                mysql_query($query) or die (mysql_error());
            }
        }
       fclose($fp);
    }

?>
