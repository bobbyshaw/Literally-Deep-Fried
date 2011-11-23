<?php
define( 'NOW',        time() );
define( 'ONE_MINUTE', 60 );
define( 'ONE_HOUR',   3600 );
define( 'ONE_DAY',    86400 );
define( 'ONE_WEEK',   ONE_DAY*7 );
define( 'ONE_MONTH',  ONE_WEEK*4 );
define( 'ONE_YEAR',   ONE_MONTH*12 );

function fuzzy_time( $time ) {
  if ( ( $time = strtotime( $time ) ) == false ) {
    return 'an unknown time';
  }
 
  // sod = start of day :)
  $sod = mktime( 0, 0, 0, date( 'm', $time ), date( 'd', $time ), date( 'Y', $time ) );
  $sod_now = mktime( 0, 0, 0, date( 'm', NOW ), date( 'd', NOW ), date( 'Y', NOW ) );
 
  // used to convert numbers to strings
  $convert = array( 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven' );
 
  // today
  if ( $sod_now == $sod ) {
    if ( $time > NOW-(ONE_MINUTE*3) ) {
      return 'just a moment ago';
    } else if ( $time > NOW-(ONE_MINUTE*7) ) {
      return 'a few minutes ago';
    } else if ( $time > NOW-(ONE_HOUR) ) {
      return 'less than an hour ago';
    }
    return 'today at ' . date( 'g:ia', $time );
  }
 
  // yesterday
  if ( ($sod_now-$sod) <= ONE_DAY ) {
    if ( date( 'i', $time ) > (ONE_MINUTE+30) ) {
      $time += ONE_HOUR/2;
    }
    return 'yesterday around ' . date( 'ga', $time );
  }
 
  // within the last 5 days
  if ( ($sod_now-$sod) <= (ONE_DAY*5) ) {
    $str = date( 'l', $time );
    $hour = date( 'G', $time );
    if ( $hour < 12 ) {
      $str .= ' morning';
    } else if ( $hour < 17 ) {
      $str .= ' afternoon';
    } else if ( $hour < 20 ) {
      $str .= ' evening';
    } else {
      $str .= ' night';
    }
    return $str;
  }
 
  // number of weeks (between 1 and 3)...
  if ( ($sod_now-$sod) < (ONE_WEEK*3.5) ) {
    if ( ($sod_now-$sod) < (ONE_WEEK*1.5) ) {
      return 'about a week ago';
    } else if ( ($sod_now-$sod) < (ONE_DAY*2.5) ) {
      return 'about two weeks ago';
    } else {
      return 'about three weeks ago';
    }
  }
 
  // number of months (between 1 and 11)...
  if ( ($sod_now-$sod) < (ONE_MONTH*11.5) ) {
    for ( $i = (ONE_WEEK*3.5), $m=0; $i < ONE_YEAR; $i += ONE_MONTH, $m++ ) {
      if ( ($sod_now-$sod) <= $i ) {
        return 'about ' . $convert[$m] . ' month' . (($m>1)?'s':'') . ' ago';
      }
    }
  }
 
  // number of years...
  for ( $i = (ONE_MONTH*11.5), $y=0; $i < (ONE_YEAR*10); $i += ONE_YEAR, $y++ ) {
    if ( ($sod_now-$sod) <= $i ) {
      return 'about ' . $convert[$y] . ' year' . (($y>1)?'s':'') . ' ago';
    }
  }
 
  // more than ten years...
  return 'more than ten years ago';
}

function toHtml($tweet) {
    
    // Add markup to tweet where necessary, e.g. links
    $text = preg_replace( '/(?<!S)((http(s?):\/\/)|(www.))+([\w.1-9\&=#?\-~%;\/]+)/',
            '<a href="http$3://$4$5">http$3://$4$5</a>', $tweet['text']);
    
    // Fuzzy-fy the time
    $time = fuzzy_time($tweet['time']);
    
    $html = <<<END
<div id="$tweet[id]" class="tweet">
    <img src="$tweet[image]" alt="$tweet[name]" title="$tweet[name]" />
    <div class="tweet-content">
        <div class="vote">
            <p class="current">$tweet[votes]</p>
            <a href="vote.php?id=$tweet[id]">WHAT A NOOB</a>
        </div>
        <a class="name" href="http://twitter.com/$tweet[screen_name]">$tweet[name]</a>
        <p>$text</p>
        <p class="meta-info"><a class="time"
            href="http://twitter.com/$tweet[screen_name]/status/$tweet[id]">$time</a></p>
    </div>
</div>
END;

    return $html;
}
