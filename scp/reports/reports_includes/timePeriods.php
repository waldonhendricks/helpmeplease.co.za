<?php

// Today
  if($_POST['range'] == 'today'){
   if($_POST['type'] == 'repliesPerStaff'){
  $qwhere = "WHERE ".TABLE_PREFIX."ticket_response.created>=CURDATE() ";
   }else{
  $qwhere = "WHERE ".TABLE_PREFIX."ticket.created>=CURDATE() ";
   }
  $report_range = "Today";
  }

  // Yesterday
  if($_POST['range'] == 'yesterday'){     
   if($_POST['type'] == 'repliesPerStaff'){
  $qwhere = "WHERE ".TABLE_PREFIX."ticket_response.created>=DATE_ADD(CURDATE(), INTERVAL -1 DAY) AND ".TABLE_PREFIX."ticket.created<CURDATE()";
   }else{
  $qwhere = "WHERE ".TABLE_PREFIX."ticket.created>=DATE_ADD(CURDATE(), INTERVAL -1 DAY) AND ".TABLE_PREFIX."ticket_response.created<CURDATE()";
   }
  $report_range = "Yesterday";
  }

  // This month
  if($_POST['range'] == 'thisMonth'){
   if($_POST['type'] == 'repliesPerStaff'){
    $qwhere = "WHERE YEAR(".TABLE_PREFIX."ticket_response.created) = YEAR(CURDATE()) AND MONTH(".TABLE_PREFIX."ticket_response.created) >= MONTH(CURDATE())";
   }else{
   $qwhere = "WHERE YEAR(".TABLE_PREFIX."ticket.created) = YEAR(CURDATE()) AND MONTH(".TABLE_PREFIX."ticket.created) >= MONTH(CURDATE())";
   }
  $report_range = "This Month";
  }

  // Last month
  if($_POST['range'] == 'lastMonth'){
   if($_POST['type'] == 'repliesPerStaff'){
  $qwhere = "WHERE YEAR(".TABLE_PREFIX."ticket_response.created) = YEAR(CURDATE()) AND MONTH(".TABLE_PREFIX."ticket_response.created) >= MONTH(DATE_ADD(CURDATE(),INTERVAL -1 MONTH)) AND MONTH(".TABLE_PREFIX."ticket_response.created) < MONTH(CURDATE())";
   }else{
  $qwhere = "WHERE YEAR(".TABLE_PREFIX."ticket.created) = YEAR(CURDATE()) AND MONTH(".TABLE_PREFIX."ticket.created) >= MONTH(DATE_ADD(CURDATE(),INTERVAL -1 MONTH)) AND MONTH(".TABLE_PREFIX."ticket.created) < MONTH(CURDATE())";
   }
  $report_range = "Last Month";
  }

  // Last 30 days
  if($_POST['range'] == 'lastThirty'){
   if($_POST['type'] == 'repliesPerStaff'){
  $qwhere = "WHERE ".TABLE_PREFIX."ticket_response.created>=DATE_ADD(CURDATE(), INTERVAL -30 DAY) ";
   }else{
  $qwhere = "WHERE ".TABLE_PREFIX."ticket.created>=DATE_ADD(CURDATE(), INTERVAL -30 DAY) ";
   }
  $report_range = "Last 30 Days";
  }

  // This week (Sun-Sat)
  if($_POST['range'] == 'thisWeek'){
   if($_POST['type'] == 'repliesPerStaff'){
  $qwhere = "WHERE ".TABLE_PREFIX."ticket_response.created>=DATE_ADD(CURDATE(), interval(1 - DAYOFWEEK(CURDATE()) ) DAY) AND ".TABLE_PREFIX."ticket_response.created<=DATE_ADD(CURDATE(), interval(7 - DAYOFWEEK(CURDATE()) ) DAY)";
  }else{
  $qwhere = "WHERE ".TABLE_PREFIX."ticket.created>=DATE_ADD(CURDATE(), interval(1 - DAYOFWEEK(CURDATE()) ) DAY) AND ".TABLE_PREFIX."ticket.created<=DATE_ADD(CURDATE(), interval(7 - DAYOFWEEK(CURDATE()) ) DAY)";
  }
  $report_range = "This Week (Sun-Sat)";
  }

  // Last week (Sun-Sat)
  if($_POST['range'] == 'lastWeek'){
   if($_POST['type'] == 'repliesPerStaff'){ $qwhere = "WHERE ".TABLE_PREFIX."ticket_response.created>=DATE_ADD(DATE_ADD(CURDATE(), interval(1 - DAYOFWEEK(CURDATE()) ) DAY), INTERVAL - 1 WEEK) AND ".TABLE_PREFIX."ticket_response.created<=DATE_ADD(DATE_ADD(CURDATE(), interval(7 - DAYOFWEEK(CURDATE()) ) DAY), interval  - 1 week)";
   }else{
   $qwhere = "WHERE ".TABLE_PREFIX."ticket.created>=DATE_ADD(DATE_ADD(CURDATE(), interval(1 - DAYOFWEEK(CURDATE()) ) DAY), INTERVAL - 1 WEEK) AND ".TABLE_PREFIX."ticket.created<=DATE_ADD(DATE_ADD(CURDATE(), interval(7 - DAYOFWEEK(CURDATE()) ) DAY), interval  - 1 week)";               
   }
  $report_range = "Last Week (Sun-Sat)";
  }

  // This Business week (Mon-Fri)
  if($_POST['range'] == 'thisBusWeek'){
   if($_POST['type'] == 'repliesPerStaff'){
   $qwhere = "WHERE ".TABLE_PREFIX."ticket_response.created>=DATE_ADD(CURDATE(), interval(2 - DAYOFWEEK(CURDATE()) ) DAY) AND ".TABLE_PREFIX."ticket_response.created<=DATE_ADD(CURDATE(), interval(6 - DAYOFWEEK(CURDATE()) ) DAY)";
    }else{
  $qwhere = "WHERE ".TABLE_PREFIX."ticket.created>=DATE_ADD(CURDATE(), interval(2 - DAYOFWEEK(CURDATE()) ) DAY) AND ".TABLE_PREFIX."ticket.created<=DATE_ADD(CURDATE(), interval(6 - DAYOFWEEK(CURDATE()) ) DAY)";
    }
  $report_range = "This Week (Mon-Fri)";
  }

  // Last Business week (Mon-Fri)
  if($_POST['range'] == 'lastBusWeek'){
   if($_POST['type'] == 'repliesPerStaff'){
  $qwhere = "WHERE ".TABLE_PREFIX."ticket_response.created>=DATE_ADD(DATE_ADD(CURDATE(), interval(2 - DAYOFWEEK(CURDATE()) ) DAY), INTERVAL - 1 WEEK) AND ".TABLE_PREFIX."ticket_response.created<=DATE_ADD(DATE_ADD(CURDATE(), interval(6 - DAYOFWEEK(CURDATE()) ) DAY), interval - 1 week)";
    }else{
  $qwhere = "WHERE ".TABLE_PREFIX."ticket.created>=DATE_ADD(DATE_ADD(CURDATE(), interval(2 - DAYOFWEEK(CURDATE()) ) DAY), INTERVAL - 1 WEEK) AND ".TABLE_PREFIX."ticket.created<=DATE_ADD(DATE_ADD(CURDATE(), interval(6 - DAYOFWEEK(CURDATE()) ) DAY), interval - 1 week)";
    }
  $report_range = "Last Business Week (Mon-Fri)";
  }

  // This year
  if($_POST['range'] == 'thisYear'){
   if($_POST['type'] == 'repliesPerStaff'){
  $qwhere = "WHERE YEAR(".TABLE_PREFIX."ticket_response.created) = YEAR(CURDATE()) ";
   }else{
  $qwhere = "WHERE YEAR(".TABLE_PREFIX."ticket.created) = YEAR(CURDATE()) ";
   }
  $report_range = "This Year";
  }

  // Last year
  if($_POST['range'] == 'lastYear'){
   if($_POST['type'] == 'repliesPerStaff'){
  $qwhere = "WHERE YEAR(".TABLE_PREFIX."ticket_response.created) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) ";
   }else{
  $qwhere = "WHERE YEAR(".TABLE_PREFIX."ticket.created) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) "; 
   }
  $report_range = "Last Year";
  }

  // All time
  if($_POST['range'] == 'allTime'){
  $qwhere = "";
  $report_range = "All Time";
  }
