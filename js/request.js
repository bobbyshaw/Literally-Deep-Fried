$(document).ready(function() {
    loadTweets(10, false);
});

var activeIds = [];

function loadTweets(qty, bookmark) {
    updateActiveIds();
    arguments = {};
    arguments.type = "GET";
    arguments.url = "load_recent_tweets.php";
    arguments.data = "next="+qty;
    arguments.success = function (html) {
        //$("#tweets").html(html);
        addIfDoesntExist($(html));

        var most_recent = $("#tweets .tweet:first-child");
        var bookmark = most_recent.attr('id');
        setTimeout("loadTweets(4, " + bookmark + ")", 2000);
    }
    if (bookmark) {
        arguments.data += "&bookmark="+bookmark;
    }
    $.ajax(arguments);
}

function updateActiveIds() {
    activeIds = [];
    $('#tweets .tweet').each(function(){
        activeIds[activeIds.length] = $(this).attr('id');
    });
}

function addIfDoesntExist(tweets) {
    tweets.each(function() {
        var addValue = true;
        for (var i = 0; i < activeIds.length; i++) {
            if (activeIds[i] == $(this).attr('id')) {
                addValue = false; 
            }
        }
        if (addValue) {
            $("#tweets").prepend($(this));
        }
    });
}
