<?php

 function getFile(){

   $time = date('U');
   $file = "Report_" .$time. ".csv";
   $file = "reports_csv/$file";
   
    return $file;

 }

 function getConfig($var){

  $sql = "SELECT $var from ".CONFIG_TABLE;
  $res = mysql_query($sql);

  $value = mysql_result($res,0);

    return $value;

 }

 function getQSelect($type){

  if($type == 'tixPerClient'){
   $qselect = "SELECT name,email,
            COUNT(DISTINCT(".TABLE_PREFIX."ticket.ticket_id)) AS number,
            COUNT(DISTINCT(CASE WHEN ".TABLE_PREFIX."ticket.status='open' THEN ".TABLE_PREFIX."ticket.ticket_id END)) as opened,
            COUNT(DISTINCT(CASE WHEN ".TABLE_PREFIX."ticket.status='closed' THEN ".TABLE_PREFIX."ticket.ticket_id END)) as closed
            FROM ".TABLE_PREFIX."ticket"; 
  }
  elseif($type == 'repliesPerStaff'){ 
   $qselect = "SELECT ".TABLE_PREFIX."staff.lastname,".TABLE_PREFIX."staff.firstname,
            COUNT(DISTINCT(".TABLE_PREFIX."ticket_response.response_id)) as responses FROM ".TABLE_PREFIX."ticket_response 
            LEFT JOIN ".TABLE_PREFIX."ticket ON ".TABLE_PREFIX."ticket.ticket_id=".TABLE_PREFIX."ticket_response.ticket_id
            LEFT JOIN ".TABLE_PREFIX."staff ON ".TABLE_PREFIX."staff.staff_id=".TABLE_PREFIX."ticket_response.staff_id "; 
  }
  elseif($type == 'tixPerTopic'){
    $qselect = "SELECT                                         
            ".TABLE_PREFIX."ticket.helptopic,
            COUNT(DISTINCT(".TABLE_PREFIX."ticket.ticket_id)) AS number FROM ".TABLE_PREFIX."ticket"; 
  }
  else{ 
    $qselect = "SELECT
            ROUND(AVG(TIMESTAMPDIFF(HOUR, ".TABLE_PREFIX."ticket.created, ".TABLE_PREFIX."ticket.closed)),2) AS hoursAVG,
            ROUND(AVG(TIMESTAMPDIFF(DAY, ".TABLE_PREFIX."ticket.created, ".TABLE_PREFIX."ticket.closed)),2) AS daysAVG,
            ".TABLE_PREFIX."ticket.dept_id,".TABLE_PREFIX."ticket.staff_id,".TABLE_PREFIX."staff.staff_id,".TABLE_PREFIX."staff.firstname,".TABLE_PREFIX."staff.lastname,
            ".TABLE_PREFIX."ticket.created,".TABLE_PREFIX."ticket.updated,".TABLE_PREFIX."ticket.closed,".TABLE_PREFIX."department.dept_name,
            COUNT(DISTINCT(".TABLE_PREFIX."ticket.ticket_id)) AS number,
            COUNT(DISTINCT(CASE WHEN ".TABLE_PREFIX."ticket.status='open' THEN ".TABLE_PREFIX."ticket.ticket_id END)) as opened,
            COUNT(DISTINCT(CASE WHEN ".TABLE_PREFIX."ticket.status='closed' THEN ".TABLE_PREFIX."ticket.ticket_id END)) as closed   
            FROM ".TABLE_PREFIX."ticket
            LEFT JOIN ".TABLE_PREFIX."ticket_response ON ".TABLE_PREFIX."ticket_response.ticket_id=".TABLE_PREFIX."ticket.ticket_id
            LEFT JOIN ".TABLE_PREFIX."staff ON ".TABLE_PREFIX."ticket.staff_id=".TABLE_PREFIX."staff.staff_id
            LEFT JOIN ".TABLE_PREFIX."department ON ".TABLE_PREFIX."ticket.dept_id=".TABLE_PREFIX."department.dept_id";
  }

        return $qselect;  

 }

 function setCSVHeaders($type){


  if($type == 'repliesPerStaff'){  
    $columnHeaders = "Last Name,First Name,Replies";  
  }
  elseif($type == 'tixPerDept'){  
    $columnHeaders = "Department,Assigned,Tickets Open,Tickets Closed,Time to Resolution";  
  }
  elseif($type == 'tixPerDay'){  
    $columnHeaders = "Day,Tickets Created,Tickets Open,Tickets Closed";  
  }
  elseif($type == 'tixPerMonth'){  
    $columnHeaders = "Month,Tickets Created,Tickets Open,Tickets Closed";  
  }
  elseif($type == 'tixPerStaff'){  
    $columnHeaders = "Staff,Assigned,Tickets,Tickets Open,Tickets Closed,Time to Resolution";  
  }
  elseif($type == 'tixPerTopic'){  
    $columnHeaders = "Help Topic,Tickets Created";  
  }
  elseif($type == 'tixPerClient'){  
    $columnHeaders = "Name/Email,Tickets Created,Tickets Open,Tickets Closed";  
  }
    return $columnHeaders;
 
 }

function duration($seconds, $max_periods = 6)
{
    $periods = array("Y" => 31536000, "M" => 2419200, "w" => 604800, "d" => 86400, "h" => 3600, "m" => 60, "s" => 1);
    $i = 1;
    foreach ( $periods as $period => $period_seconds )
    {   
        $period_duration = floor($seconds / $period_seconds);
        $seconds = $seconds % $period_seconds;
        if ( $period_duration == 0 ) continue;
        $duration[] = "{$period_duration}{$period}" . ($period_duration > 1 ? '' : '');
        $i++;
        if ( $i >  $max_periods ) break;
    }
    return implode(' ', $duration);
}
