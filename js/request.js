$(document).ready(function() {
    loadTweets(10, false);
});

function loadTweets(qty, bookmark) {
    if (bookmark == false) {
        $.ajax({
            type: "GET",
            url: "load_recent_tweets.php",
            data: "next="+qty,
            success: function (html) {
                $("#tweets").html(html);

                var most_recent = $("#tweets .tweet:first-child");
                var bookmark = most_recent.attr('id');
                setTimeout("loadTweets(4, " + bookmark + ")", 2000);
            }
        });
    } else {
        // Schedule the next request
        $.ajax({
            type: "GET",
            url: "load_recent_tweets.php",
            data: "next="+qty+"&bookmark="+bookmark,
            success: function (html) {
                // We have called this before so let's prepend the new tweets. 
                $("#tweets").prepend(html);

                var most_recent = $("#tweets .tweet:first-child");
                var bookmark = most_recent.attr('id');
                setTimeout("loadTweets(4, " + bookmark + ")", 2000);
            }
        });
    }
}
