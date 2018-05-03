<?php

// MySQL Query from HELL
$query = "
SELECT 
AVG(
FLOOR(DATEDIFF(
(SELECT sec.created 
 FROM ".TICKET_RESPONSE_TABLE." as sec 
 WHERE main.ticket_id = sec.ticket_id
 GROUP BY sec.ticket_id)
,main.created)/7)*5 +
DATEDIFF(
(SELECT sec.created 
 FROM ".TICKET_RESPONSE_TABLE." as sec 
 WHERE main.ticket_id = sec.ticket_id
 GROUP BY sec.ticket_id)
,main.created)%7 -
IF( DAYOFWEEK(main.created) = 1, IF(DAYOFWEEK(
(SELECT sec.created 
 FROM ".TICKET_RESPONSE_TABLE." as sec 
 WHERE main.ticket_id = sec.ticket_id
 GROUP BY sec.ticket_id)
) = 7, 2, 1),
  IF( DAYOFWEEK(main.created) = 7, IF(DAYOFWEEK(
(SELECT sec.created 
 FROM ".TICKET_RESPONSE_TABLE." as sec 
 WHERE main.ticket_id = sec.ticket_id
 GROUP BY sec.ticket_id)
) = 1, 1, 2),
    IF( DAYOFWEEK(
(SELECT sec.created 
 FROM ".TICKET_RESPONSE_TABLE." as sec 
 WHERE main.ticket_id = sec.ticket_id
 GROUP BY sec.ticket_id)
) < DAYOFWEEK(main.created), 2, 0 )))
) as fubar
FROM ".TICKET_TABLE." as main";

$result=mysql_query($query);
$fu = mysql_result($result,0);

// convert days to seconds (*24 hours *60 minutes *60seconds)
$timeInSeconds = $fu * 24 * 60 * 60;
 
echo "<b>All Time:</b> ".duration($timeInSeconds)."<br>";
 
?>
