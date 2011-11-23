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
