var activeIds = [];
var tweetsToShow = [];
var update = true;

$(document).ready(function() {
    loadTweets(10, false);
    showNextTweet();
    $('#tweets').hover( function(eventObject) {
        update = false;
    }, function(eventObject) {
        update = true;
    });
});

function loadTweets(qty, bookmark) {
    updateActiveIds();
    arguments = {};
    arguments.type = "GET";
    arguments.url = "load_recent_tweets.php";
    arguments.data = "next="+qty;
    arguments.success = function (html) {
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
            var newTweet = $("#tweets").prepend($(this));
            tweetsToShow.push($(this));
            $(this).hide();
        }
    });
}

function showNextTweet() {
    if (tweetsToShow.length != 0 && update) {
        var nextTweet = tweetsToShow.shift();
        nextTweet.fadeIn(1000);
    }
    setTimeout("showNextTweet()", 2000);
}
