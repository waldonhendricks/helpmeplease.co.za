<?php
 
  $fromDate = $_POST['fromDate'];
  $toDate = $_POST['toDate'];
  if($_POST['type'] == 'repliesPerStaff'){
   $qwhere = "WHERE ".TABLE_PREFIX."ticket_response.created>=\"$fromDate 00:00:00\" AND ".TABLE_PREFIX."ticket_response.created<=\"$toDate 23:59:59\" ";
  }
  else{
   $qwhere = "WHERE ".TABLE_PREFIX."ticket.created>=\"$fromDate 00:00:00\" AND ".TABLE_PREFIX."ticket.created<=\"$toDate 23:59:59\" ";
  }
  $report_range = $fromDate. " to " .$toDate; 
