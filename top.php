<?php
    require_once('config.php');
    require_once('func.php');
    
    mysql_connect($server, $username, $password) or die (mysql_error());
    mysql_select_db($database) or die (mysql_error());

    date_default_timezone_set('Europe/Dublin');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="keywords" content="grammar nazi" />
        <meta name="description" content="An example of using the twitter stream API looking for ridiculous use of the word 'literally'." />
        <link href="css/normalize.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/styles.css" rel="stylesheet" type="text/css" media="all" />
        <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
        <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js?ver=3.1.3'></script> 
        <title>Literally deep fried - Top Fools</title>
    </head>

    <body>

        <nav class="top-navigation">
            <ul>
                <li><a href="about">About</a></li>
                <li><a href="top-fools" class="active">Top Fools</a></li>
                <li><a href="latest-tweets">Latest Tweets</a></li>
            </ul>
        </nav>

        <header>
            <h1>Literally deep fried</h1>
        </header>

        <section class="container">
            <div class="page-title">
                <h3>Hall of N00Bs</h3> 
            </div>
            <div id="tweets">
                <?php 
                $query = "SELECT * from tweets WHERE votes > 0 AND time > NOW() - INTERVAL 1 WEEK order by votes desc limit 10";
                $result = mysql_query($query) or die (mysql_error());

                while($tweet = mysql_fetch_array($result)) {
                    echo toHtml($tweet);
                }
                ?>
            </div>
        </section>


        <footer>
            <p class="cloud">Imagined by <br/><a href="http://tomrobertshaw.net">Tom Robertshaw</a> <br/>and <br/><a href="#">Martin Shaw</a></p>
        </footer>
    </body>
</html>
