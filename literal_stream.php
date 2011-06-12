<!DOCTYPE html>
<html>
    <head>
       <meta charset="utf-8" />  
       <meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
                               
    </head>
    <body>


<?php
    set_time_limit(0);

    date_default_timezone_set('Europe/Dublin');

    $query_data = array('track' => 'literally');
    $user = 'tooliteral'; // replace with your account
    $pass = 'grammarnazi'; // replace with your account
 
    $fp = fsockopen("stream.twitter.com", 80, $errno, $errstr, 30);
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
            if($tweet){
            ?>
                <?php print_r($tweet) ?> 
                <div class="tweet">     
                    <img src="<?php echo $tweet['user']['profile_image_url'] ?>" alt="Profile Image" />
                    <a href="http://www.twitter.com/<?php echo $tweet['user']['screen_name'] ?>" title="<?php echo $tweet['user']['name']; ?>"><?php echo $tweet['name'] ?></a>
                    <p><?php echo $tweet['text'] ?></p>

                    <?php $time = date("d/m/y H:i",strtotime($tweet['created_at'])); ?>
                    <a href="<?php echo "http://www.twitter.com/" . $tweet['screen_name'] . "/status/" . $tweet['id_str'] ?>"><?php echo $time; ?></a>
            
                </div>
            <?php
            }
        }
       fclose($fp);
    }


?>
</body>
</html>
