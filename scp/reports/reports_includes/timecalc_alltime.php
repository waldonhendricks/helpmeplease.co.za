<?php

$year = date('Y') -1;

$query = "SELECT AVG(
 FLOOR(DATEDIFF(closed,created)/7)*5 +
 DATEDIFF(closed,created)%7 -
 IF( DAYOFWEEK(created) = 1, IF(DAYOFWEEK(closed) = 7, 2, 1),
   IF( DAYOFWEEK(created) = 7, IF(DAYOFWEEK(closed) = 1, 1, 2),
     IF( DAYOFWEEK(closed) < DAYOFWEEK(created), 2, 0 ))) 
) as fubar FROM ".TICKET_TABLE." 
WHERE closed IS NOT NULL;";

$result=mysql_query($query);

// set var
$fu = mysql_result($result,0,"fubar");

// convert days to seconds (*24 hours *60 minutes *60seconds)
$timeInSeconds = $fu * 24 * 60 * 60;
 
echo "<b>All Time:</b> ".duration($timeInSeconds,6)."<br>";

?>
