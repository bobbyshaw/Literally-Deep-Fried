<!DOCTYPE html>
<html>
    <head>
        <meta name="keywords" content="grammar nazi" />
        <meta name="description" content="An example of using the twitter stream API looking for ridiculous use of the word 'literally'." />
        <link href="css/normalize.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/styles.css" rel="stylesheet" type="text/css" media="all" />
        <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
        <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js?ver=3.1.3'></script> 
        <title>Literally deep fried</title>
    </head>

    <body>

        <nav class="top-navigation">
            <ul>
                <li><a href="about">About</a></li>
                <li><a href="top-fools">Top Fools</a></li>
                <li><a href="latest-tweets">Latest Tweets</a></li>
            </ul>
        </nav>

        <header>
            <h1>Literally deep fried</h1>
        </header>

        <section class="container">
            <div class="page-title">
                <h3>Recent Tweets</h3> 
            </div>
            <div id="tweets">

            </div>
        </section>


        <footer>
            <p class="cloud">Imagined by <br/><a href="http://tomrobertshaw.net">Tom Robertshaw</a></p>
        </footer>

        <script>
            $(document).ready(function() {
                var getTweets = $.ajax({
                    type: "GET",
                    url: "load_recent_tweets.php",
                    data: "next=10",
                    success: function (html) {
                        $("#tweets").html(html);
                    }
                });
            });
        </script>
    </body>
</html>
