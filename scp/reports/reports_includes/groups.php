<?php 

 // Tickets Per Department
 if($_POST['type'] == 'tixPerDept'){
    $qgroup = "GROUP BY ".TABLE_PREFIX."department.dept_id ORDER BY number DESC"; 
    $report_type = "Tickets Per Department"; 
 } 

 // Tickets Per Staff
 elseif($_POST['type'] == 'tixPerStaff'){ 
    $qgroup = "GROUP BY ".TABLE_PREFIX."staff.staff_id ORDER BY ".TABLE_PREFIX."staff.lastname "; 
    $report_type = "Tickets Per Staff"; 
 } 

 // Replies Per Staff
 elseif($_POST['type'] == 'repliesPerStaff'){ 
    $qgroup = "GROUP BY ".TABLE_PREFIX."staff.staff_id ORDER BY ".TABLE_PREFIX."staff.lastname "; 
    $report_type = "Replies Per Staff"; 
 } 

 // Tickets Per Day
 elseif($_POST['type'] == 'tixPerDay'){ 
    $qgroup = "GROUP BY DATE_FORMAT(".TABLE_PREFIX."ticket.created, '%d %M %Y') ORDER BY ".TABLE_PREFIX."ticket.created  "; 
    $report_type = "Tickets Per Day"; 
 } 

 // Tickets Per Month
 elseif($_POST['type'] == 'tixPerMonth'){ 
    $qgroup = "GROUP BY DATE_FORMAT(".TABLE_PREFIX."ticket.created, '%M %Y') ORDER BY ".TABLE_PREFIX."ticket.created"; 
    $report_type = "Tickets Per Month"; 
 } 

 // Tickets Per Topic
 elseif($_POST['type'] == 'tixPerTopic'){ 
    $qgroup = "GROUP BY ".TABLE_PREFIX."ticket.helptopic ORDER BY ".TABLE_PREFIX."ticket.helptopic";
    $report_type = "Tickets Per Help Topic"; 
 } 

 // Tickets Per Client
 elseif($_POST['type'] == 'tixPerClient'){ 
    $qgroup = "GROUP BY email ORDER BY email"; 
    $report_type = "Tickets Per Client"; 
 }
