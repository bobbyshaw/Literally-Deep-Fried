<?php

require_once('config.php');

mysql_connect($server, $username, $password) or die (mysql_error());
mysql_select_db($database) or die (mysql_error());

date_default_timezone_set('Europe/Dublin');

// Check for tweet id
if (isset($_GET['id'])) {
    $id = mysql_real_escape_string($_GET['id']);

    $query = "UPDATE tweets SET votes = (votes + 1) WHERE id = $id;";
    $result = mysql_query($query) or die (mysql_error());
}

?>