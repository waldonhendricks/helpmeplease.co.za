<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<link href="reports_css/style.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript" src="reports_js/reports.js"></script>
<?php 

$VERSION = '5.0';
/******************************************************************
                                                                 
  osTickets Reporting Module                                      
  Author: Scott Rowley                                           
  Last Updated: 06/22/2012                                       
                                                                 
  Information and assistance regarding this MOD                   
  can be found at the following URL                             
  http://sudobash.net/ostickets-reports/                        
                                                                 
  If you've been using my MODs report prior to 5.0
  you will notice that the structure is beginning to change
  functions are more heavily used and sections of code have
  been broken up to make them more manageable.  This will
  continue to happen in future releases for ease of trouble 
  shooting and code manipulation.

******************************************************************/
require_once('reports_includes/functions.php'); 


 // Change this from 0 to 1 if you want to use the pChart pie on
 // the reports page instead of the reactive google pie.
 // Keeping this a 0 will still have the pChart email show up
 // in email.
 $usePChart = 0;

 $pChart = getcwd().'/reports_includes/pChart';

 /* pChart library inclusions */
 require_once("$pChart/class/pData.class.php");
 require_once("$pChart/class/pDraw.class.php");
 require_once("$pChart/class/pPie.class.php");
 require_once("$pChart/class/pImage.class.php");

// Get date for export file

$file = getFile();

require('staff.inc.php');

$page='';

$nav->setTabActive('Reports');
$nav->addSubMenu(array('desc'=>'Reports','href'=>'reports.php','iconclass'=>''));

if($thisuser->isAdmin()){
$nav->addSubMenu(array('desc'=>'Report Settings','href'=>'reports_admin.php','iconclass'=>''));
}
require_once(STAFFINC_DIR.'header.inc.php');

// echo getConfig('ostversion');

// If form has not been submitted yet then create a default report.
if(!isset($_POST['submit'])){
    $_POST['type'] = 'tixPerDept';
    $_POST['submit'] = 'submit';
    $_POST['dateRange'] = 'timePeriod';
    $_POST['range'] = 'thisWeek';
}


   // Main Content sections
   // Made requires to make them easy to move around if you want to re-organize
   // Or if you simply don't want quick stats just comment out the line
   require_once('reports_includes/quickStats.php'); 
   require_once('reports_includes/reportsForm.php');

if(isset($_POST['submit'])){ 

// Get the report options
$OptionsQuery = "SELECT 3d,graphWidth,graphHeight,resolution,viewable from ".REPORTS_TABLE." LIMIT 1";
$OptionsResult = mysql_query($OptionsQuery) or die(mysql_error());

while($graphOptions = mysql_fetch_array($OptionsResult)){

//// Prepare the select query depending on the report we want.

// Report type department
// Probably not as clean as it could be but.... it works.
// I'm not using the closed count but I'm leaving it here in case anyone wants to easily reference it.

$qselect = getQSelect($_POST['type']);

// Create CSV file column headers
$fh = fopen($file, 'w') or die("Can't open $file");
fwrite($fh, setCSVHeaders($_POST['type']));

// Time Periods
if($_POST['dateRange'] == 'timePeriod'){ require_once('reports_includes/timePeriods.php'); }

// Specified time range
if($_POST['dateRange'] == 'timeRange'){ require_once('reports_includes/timeRange.php'); }

// Setup groupings
require_once('reports_includes/groups.php');

// Form the entire query
$query="$qselect $qwhere $qgroup";

// Run the query
$result = mysql_query($query) or die(mysql_error());
$graphResult = mysql_query($query) or die(mysql_error());

// Count the rows 
$num_rows = mysql_num_rows($graphResult);

if($num_rows>0){
?>

<div class='section-header'>
 <span class='section-title'><?php echo $report_type.": ".$report_range; ?></span>
</div>

<div class='section-content'> <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    
      // Load the Visualization API and the piechart package.
      google.load('visualization', '1', {'packages':['corechart']});
      
      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);
      
      // Callback that creates and populates a data table, 
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

      // Create our data table.
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Department');
      data.addColumn('number', 'Tickets');
      data.addRows([

   // Get the total of each ticket category - start with a 0 
   <?
   $Total = 0;
   $resolutionTotal = 0;
   $responseTotal = 0;
   $closedTotal = 0;
   $openedTotal = 0;
   $i = 1;

   while($graphRow = mysql_fetch_array($graphResult)){

    if($i < $num_rows){ $comma = ','; }else{ $comma = ''; }

   // Now add each new row to the total
   $Total += $graphRow['number'];
   $closedTotal += $graphRow['closed'];
   $openedTotal += $graphRow['opened'];

   if($graphOptions['resolution']=='hours'){
   $resolutionTotal += $graphRow['hoursAVG'];
   }
   elseif($graphOptions['resolution']=='days'){
   $resolutionTotal += $graphRow['daysAVG'];
   }

   $responseTotal += $graphRow['responses'];
   $resolutionAVG = round($resolutionTotal/$num_rows,2);


        if($_POST['type'] == 'tixPerDept'){

            $graphNumber   = $graphRow['number'];
            $numsArray[] = $graphNumber;
            $deptsArray[] = $graphRow['dept_name'];
            $selectedArray = $deptsArray;
            $graphDeptName = $graphRow['dept_name'];

            echo "['$graphDeptName', $graphNumber],";
            $i++;
          }

        if($_POST['type'] == 'tixPerTopic'){
        
            $graphNumber   = $graphRow['number'];
            $numsArray[] = $graphNumber;
            $graphTopic = $graphRow['helptopic'];
            if($graphTopic!=NULL){ $topicsArray[] = $graphTopic; } else { $topicsArray[] = 'None'; }
            $selectedArray = $topicsArray;

           if($graphTopic==NULL){ $graphTopic='None'; }
           echo "['$graphTopic', $graphNumber],";
           $i++;
          }

        if($_POST['type'] == 'tixPerStaff'){

            $graphNumber   = $graphRow['number'];
            $numsArray[] = $graphNumber;

            if($graphRow['staff_id'] == NULL){
             $graphRow['lastname'] = Unassigned;
             $graphRow['firstname'] = Tickets;
            }

            $graphLastName = $graphRow['lastname'];
            $graphFirstName = $graphRow['firstname'];

            $staffArray[] = $graphLastName.", ".$graphFirstName;
            $selectedArray = $staffArray;

          echo "['$graphLastName, $graphFirstName', $graphNumber],";
          $i++;
          }

        if($_POST['type'] == 'tixPerDay'){

            $graphNumber   = $graphRow['number'];
            $numsArray[] = $graphNumber;
            $graphCreated = $graphRow['created'];
            $graphDate = date("F j Y", strtotime($graphCreated));
            $DateArray[] = $graphDate;
            $selectedArray = $DateArray;

            echo "['$graphDate', $graphNumber],";
            $i++;
          }

        if($_POST['type'] == 'repliesPerStaff'){
         $graphLastName = $graphRow['lastname'];
         $graphFirstName = $graphRow['firstname'];
         if(($graphLastName == NULL) && ($graphFirstName == NULL)){
        $graphLastName = Deleted;
        $graphFirstName = Staff;
          }
          $graphResponses = $graphRow['responses'];
          $responsesArray[] = $graphLastName.", ".$graphFirstName;
          $numsArray[] = $graphResponses;
          $selectedArray = $responsesArray;
          echo "['$graphLastName, $graphFirstName', $graphResponses]$comma";
          $Total += $graphResponses;
          $i++;
          }

      if($_POST['type'] == 'tixPerMonth'){
           $graphNumber = $graphRow['number'];
           $numsArray[] = $graphNumber;
           $graphDate = date("F, Y", strtotime($graphRow['created']));
           $dateArray[] = $graphDate;
           $selectedArray = $dateArray;
           echo "['$graphDate', $graphNumber]$comma";
           $i++;
          }

      if($_POST['type'] == 'tixPerClient'){
      $graphEmail = $graphRow['email'];
      $graphNumber = $graphRow['number'];
      if(!filter_var($graphEmail, FILTER_VALIDATE_EMAIL)){
       $graphEmail = $graphRow['name'];
      }
       $emailArray[] = $graphEmail;
       $selectedArray = $emailArray;
       $numsArray[] = $graphNumber;
       echo "['$graphEmail', $graphNumber]$comma";
       $i++;
    }


      }?>
      ]);

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      <? if($graphOptions['3d']=='1'){ $threeD='true'; }else{ $threeD='false'; }?>
      chart.draw(data, {width: <?=$graphOptions['graphWidth'];?>, height: <?=$graphOptions['graphHeight'];?>, is3D: <?=$threeD;?>, sliceVisibilityThreshold: 1/72000});
    
    }    
    </script>

<?php

 foreach($numsArray as $num){
  $percents[] = round((($num / $Total) * 100),2);
 }

 /* Create and populate the pData object */
 $MyData = new pData();
 $MyData->addPoints($percents,"ScoreA");
 $MyData->setSerieDescription("ScoreA","Application A");

 /* Define the absissa serie */
 $MyData->addPoints($selectedArray,"Labels");
 $MyData->setAbscissa("Labels");

 /* Create the pChart object */
 $myPicture = new pImage(800,200,$MyData,TRUE);

 /* Set the default font properties */
 $myPicture->setFontProperties(array("FontName"=>"$pChart/fonts/GeosansLight.ttf","FontSize"=>12,"R"=>0,"G"=>0,"B"=>0));

 /* Create the pPie object */
 $PieChart = new pPie($myPicture,$MyData);

 /* Enable shadow computing */
 $myPicture->setShadow(TRUE,array("X"=>3,"Y"=>3,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

 /* Draw a splitted pie chart */
 $PieChart->draw3DPie(250,100,array("WriteValues"=>TRUE,"Radius"=>150,"DataGapAngle"=>4,"DataGapRadius"=>10,"Border"=>TRUE));

 /* Write the legend box */
 $PieChart->drawPieLegend(500,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_VERTICAL));

 // Report images dir is in relation to DocumentRoot/scp/
 $report_images_dir = "reportImages/";
 $browser_image_name = $report_images_dir."pChart.png";
 $myPicture->render("$browser_image_name");


 $image_location = $helpdesk_url.$browser_image_name;

 if($usePChart == 1){?>
  <div id='usePChart'>
   <img src='<?php echo $browser_image_name; ?>' />
  </div>
 <?}else{?>
    <div id="chart_div"></div>
 <? } ?>

  <div id='csvLink'>
   <a href="<?=$file?>" />
    <img src='reports_images/csv.png' width="50px" height="50px"/>
   </a>
  </div>
 </div> <!-- end graph div -->

<table id="hor-minimalist-b" width="100%"> <?

// Print out results of query for department reports  

if($graphOptions['resolution']=='hours'){ $time = 'Hours'; }else{ $time = 'Days'; }

 if($_POST['type'] == 'tixPerDept'){ 
    echo "<tr><th>Department</th><th>Assigned</th><th>Tickets Open<th>Tickets Closed</th><th>$time to Resolution (Avg)</th></tr>";  
    $emailPlainRows[]= "Department  Assigned Tickets Open Tickets Closed $time to Resolution (Avg)";
    $emailHTMLRows[] = "<tr><th>Department</th><th>Assigned</th><th>Tickets Open<th>Tickets Closed</th><th>$time to Resolution (Avg)</th></tr>";
 }  
 elseif($_POST['type'] == 'tixPerStaff'){  
    echo "<tr><th>Staff</th><th>Assigned</th><th>Tickets Open<th>Tickets Closed</th><th>$time to Resolution (Avg)</th></tr>";  
    $emailPlainRows[]= "Staff  Assigned Tickets Open Tickets Closed $time to Resolution (Avg)";
    $emailHTMLRows[]="<tr><th>Staff</th><th>Assigned</th><th>Tickets Open<th>Tickets Closed</th><th>$time to Resolution (Avg)</th></tr>";
 }  
 elseif($_POST['type'] == 'tixPerTopic'){  
    echo "<tr><th>Help Topic</th><th>Tickets</th></tr>";  
    $emailPlainRows[]= "Help Topic  Tickets";
    $emailHTMLRows[] = "<tr><th>Help Topic</th><th>Tickets</th></tr>";
 }  
 elseif($_POST['type'] == 'repliesPerStaff'){  
    echo "<tr><th>Staff</th><th>Replies</th></tr>";
    $emailPlainRows[]= "Staff  Replies";
    $emailHTMLRows[] = "<tr><th>Staff</th><th>Replies</th></tr>";
 }
 elseif($_POST['type'] == 'tixPerDay'){ 
    echo "<tr><th>Day</th><th>Tickets Created</th><th>Tickets Open<th>Tickets Closed</th></tr>";  
   $emailPlainRows[]= "Day  Tickets Created Tickets Open Tickets Closed";
   $emailHTMLRows[]="<tr><th>Day</th><th>Tickets Created</th><th>Tickets Open<th>Tickets Closed</th></tr>";
 }  
 elseif($_POST['type'] == 'tixPerMonth'){  
    echo "<tr><th>Month</th><th>Tickets Created</th><th>Tickets Open<th>Tickets Closed</th></tr>";  
   $emailPlainRows[]= "Month  Tickets Created Tickets Open Tickets Closed";
   $emailHTMLRows[] = "<tr><th>Month</th><th>Tickets Created</th><th>Tickets Open<th>Tickets Closed</th></tr>";
 }  
 elseif($_POST['type'] == 'tixPerClient'){  
    echo "<tr><th>Name/Email</th><th>Tickets Created</th><th>Tickets Open<th>Tickets Closed</th></tr>"; 
   $emailPlainRows[]= "Name/Email  Tickets Created Tickets Open Tickets Closed";
   $emailHTMLRows[] = "<tr><th>Name/Email</th><th>Tickets Created</th><th>Tickets Open<th>Tickets Closed</th></tr>";
 }

  while($row = mysql_fetch_array($result)){ 

   if($graphOptions['resolution']=='hours'){ 
    $time = $row['hoursAVG']; 
   }elseif($graphOptions['resolution']=='days'){ 
    $time = $row['daysAVG']; 
   } 

   if($row['open']=='0'){ 
    $row['open']=''; 
   } 

   if($_POST['type'] == 'tixPerDept'){ 
    echo "<tr><td>" . $row['dept_name']. "</td><td>" . $row['number'] ." </td><td>" .$row['opened']. "</td><td>" .$row['closed']. "</td><td>" .$time. "</td></tr> ";

    // Now for the file
    $columnHeaders = "\n" .$row['dept_name']. "," .$row['number']. "," .$row['opened']. "," .$row['closed']. "," .$time;  fwrite($fh, $columnHeaders);

    // Email
    $emailPlainRows[] = "\n" .$row['dept_name']. " " .$row['number']. " " .$row['opened']. " " .$row['closed']. " " .$time;
    $emailHTMLRows[] = "<tr><td>" . $row['dept_name']. "</td><td>" . $row['number'] ." </td><td>" .$row['opened']. "</td><td>" .$row['closed']. "</td><td>" .$time. "</td></tr> ";
  }
  elseif($_POST['type'] == 'tixPerTopic'){  
   if($row['helptopic'] == NULL){  
    $row['helptopic'] = None; 
   } 
   echo "<tr><td>" . $row['helptopic']. "</td><td>" . $row['number'] ." </td></tr> ";
 
   // Now for the file
   $columnHeaders = "\n" .$row['helptopic']. "," .$row['number'];  fwrite($fh, $columnHeaders);

   // Email
   $emailPlainRows[] = "\n" .$row['helptopic']. " " .$row['number'];
   $emailHTMLRows[] = "<tr><td>" . $row['helptopic']. "</td><td>" . $row['number'] ." </td></tr> ";

  }
  elseif($_POST['type'] == 'tixPerStaff'){  
   if($row['staff_id'] == NULL){  
    $row['lastname'] = Unassigned;  
    $row['firstname'] = Tickets;  
   }  
   echo "<tr><td>" . $row['lastname']. ", " .$row['firstname'] . "</td><td>" . $row['number'] ." </td><td>" .$row['opened']. "</td><td>" .$row['closed']. "</td><td>" .$time. "</td></tr> ";

   // Now for the file
   $columnHeaders = "\n" .$row['lastname']. "," .$row['firstname']. "," .$row['number']. "," .$row['opened']. "," .$row['closed']. "," .$time;  fwrite($fh, $columnHeaders);

   // Email
   $emailPlainRows[] = "\n" .$row['lastname']. " " .$row['firstname']. " " .$row['number']. " " .$row['opened']. " " .$row['closed']. " " .$time;
   $emailHTMLRows[] = "<tr><td>" . $row['lastname']. ", " .$row['firstname'] . "</td><td>" . $row['number'] ." </td><td>" .$row['opened']. "</td><td>" .$row['closed']. "</td><td>" .$time. "</td></tr> ";

  }
  elseif($_POST['type'] == 'repliesPerStaff'){  
   if($row['lastname'] == NULL){  
    $row['lastname'] = Deleted;  
    $row['firstname'] = Employee;  
   }  
   echo "<tr><td>" . $row['lastname']. ", " .$row['firstname'] . "</td><td>" . $row['responses'] ." </td></tr> ";

   // Now for the file
   $columnHeaders = "\n" .$row['lastname']. "," .$row['firstname']. "," .$row['responses'];  fwrite($fh, $columnHeaders);

   // Email
   $emailPlainRows[] = "\n" .$row['lastname']. " " .$row['firstname']. " " .$row['responses'];
   $emailHTMLRows[] = "<tr><td>" . $row['lastname']. ", " .$row['firstname'] . "</td><td>" . $row['responses'] ." </td></tr> ";

  }
  elseif($_POST['type'] == 'tixPerClient'){  
   $email = $row['email'];  
   if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $email = $row['name'];
   }
   echo "<tr><td>" . $email. "</td><td>" . $row['number'] ." </td><td>" .$row['opened']. "</td><td>" .$row['closed']. "</td></tr>";

   // Now for the file
   $columnHeaders = "\n" .$email. "," .$row['number']. "," .$row['opened']. "," .$row['closed'];  fwrite($fh, $columnHeaders);

   // Email
   $emailPlainRows[] = "\n" .$email. " " .$row['number']. " " .$row['opened']. " " .$row['closed'];
   $emailHTMLRows[] = "<tr><td>" . $email. "</td><td>" . $row['number'] ." </td><td>" .$row['opened']. "</td><td>" .$row['closed']. "</td></tr>";

  }
  elseif($_POST['type'] == 'tixPerDay'){
  echo "<tr><td>" . date("j F Y", strtotime($row['created'])). "</td><td>" . $row['number'] ." </td><td>" .$row['opened']. "</td><td>" .$row['closed']. "</td></tr> ";

  // Now for the file
  $columnHeaders = "\n" .date("j F Y", strtotime($row['created'])). "," .$row['number']. "," .$row['opened']. "," .$row['closed'];  fwrite($fh, $columnHeaders);

  // Email
  $emailPlainRows[] = "\n" .date("j F Y", strtotime($row['created'])). " " .$row['number']. " " .$row['opened']. " " .$row['closed'];
  $emailHTMLRows[] = "<tr><td>" . date("j F Y", strtotime($row['created'])). "</td><td>" . $row['number'] ." </td><td>" .$row['opened']. "</td><td>" .$row['closed']. "</td></tr> ";

  }
  elseif($_POST['type'] == 'tixPerMonth'){  
  echo "<tr><td>" . date("F, Y", strtotime($row['created'])). "</td><td>" . $row['number'] ." </td><td>" .$row['opened']. "</td><td>" .$row['closed']. "</td></tr> ";

  // Now for the file
  $columnHeaders = "\n" .date("j F Y", strtotime($row['created'])). "," .$row['number']. "," .$row['opened']. "," .$row['closed'];  fwrite($fh, $columnHeaders);

  // Email
  $emailPlainRows[] =   "\n" .date("j F Y", strtotime($row['created'])). " " .$row['number']. " " .$row['opened']. " " .$row['closed'];
  $emailHTMLRows[] = "<tr><td>" . date("F, Y", strtotime($row['created'])). "</td><td>" . $row['number'] ." </td><td>" .$row['opened']. "</td><td>" .$row['closed']. "</td></tr> ";

  }
 }
}

if($num_rows>0){
?>
<?if($_POST['type'] == 'tixPerDept'){?>
 <tr class='totalRow'><td>Total</td><td><?=$Total;?></td><td><?=$openedTotal?></td><td><?=$closedTotal?></td><td><?=$resolutionAVG;?></td></tr>

 <? 
 // Now for the file
 $columnHeaders = "\n" . "Total" . "," .$Total. "," .$openedTotal. "," .$closedTotal. "," .$resolutionAVG;  fwrite($fh, $columnHeaders);
 
 // Email
 $emailPlainRows[] = "\n" . "Total" . " " .$Total. " " .$openedTotal. " " .$closedTotal. " " .$resolutionAVG;
 $emailHTMLRows[] = "<tr class='totalRow'><td>Total</td><td>$Total</td><td>$openedTotalg</td><td>$closedTotal</td><td>$resolutionAVG</td></tr>";
 }
 elseif($_POST['type'] == 'tixPerTopic'){?>  
     <tr class='totalRow'><td>Total</td><td><?=$Total;?></td></tr>

 <? 
 // Now for the file
 $columnHeaders = "\n" . "Total" . "," .$Total;  fwrite($fh, $columnHeaders);

 // Email
 $emailPlainRows[] = "\n" . "Total" . " " .$Total;
 $emailHTMLRows[] = "<tr class='totalRow'><td>Total</td><td>$Total</td></tr>";
 }
elseif($_POST['type'] == 'tixPerStaff'){?>
    <tr class='totalRow'><td>Total</td><td><?=$Total;?></td><td><?=$openedTotal?></td><td><?=$closedTotal?></td><td><?=$resolutionAVG;?></td></tr>     

 <? 
 // Now for the file
 $columnHeaders = "\n" . "Total" . ",," .$Total. "," .$openedTotal. "," .$closedTotal. "," .$resolutionAVG;  fwrite($fh, $columnHeaders);

 // Email
 $emailPlainRows[] = "\n" . "Total" . "  " .$Total. " " .$openedTotal. " " .$closedTotal. " " .$resolutionAVG;
 $emailHTMLRows[] = "<tr class='totalRow'><td>Total</td><td>$Total</td><td>$openedTotal</td><td>$closedTotal</td><td>$resolutionAVG</td></tr>";
 }
 elseif($_POST['type'] == 'repliesPerStaff'){?>  
     <tr class='totalRow'><td>Total</td><td><?=$responseTotal;?></td></tr>

 <? 
 // Now for the file    
 $columnHeaders = "\n" . "Total" . ",," .$responseTotal;  fwrite($fh, $columnHeaders);

 // Email
 $emailPlainRows[] = "\n" . "Total" . " " .$responseTotal;
 $emailHTMLRows[] = "<tr class='totalRow'><td>Total</td><td>$responseTotal</td></tr>";
 }
 elseif($_POST['type'] == 'tixPerDay'){?>
     <tr class='totalRow'><td>Total</td><td><?=$Total;?></td><td><?=$openedTotal?></td><td><?=$closedTotal?></td></tr>     

 <? 
 // Now for the file
 $columnHeaders = "\n" . "Total" . "," .$Total. "," .$openedTotal. "," .$closedTotal;  fwrite($fh, $columnHeaders);

 // Email
 $emailPlainRows[] = "\n" . "Total" . " " .$Total. " " .$openedTotal. " " .$closedTotal;
 $emailHTMLRows[] = "<tr class='totalRow'><td>Total</td><td>$Total</td><td>$openedTotal</td><td>$closedTotal</td></tr>";
 }
 elseif($_POST['type'] == 'tixPerClient'){?>  
     <tr class='totalRow'><td>Total</td><td><?=$Total;?></td><td><?=$openedTotal?></td><td><?=$closedTotal?></td></tr>

 <? 
 // Now for the file
 $columnHeaders = "\n" . "Total" . "," .$Total. "," .$openedTotal. "," .$closedTotal;  fwrite($fh, $columnHeaders);

 // Email
 $emailPlainRows[] = "\n" . "Total" . " " .$Total. " " .$openedTotal. " " .$closedTotal;
 $emailHTMLRows[] = "<tr class='totalRow'><td>Total</td><td>$Total</td><td>$openedTotal</td><td>$closedTotal</td></tr>";
 }
 elseif($_POST['type'] == 'tixPerMonth'){?>  
     <tr class='totalRow'><td>Total</td><td><?=$Total;?></td><td><?=$openedTotal?></td><td><?=$closedTotal?></td></tr>

 <? 
 // Now for the file
 $columnHeaders = "\n" . "Total" . "," .$Total. "," .$openedTotal. "," .$closedTotal;  fwrite($fh, $columnHeaders);

 // Email
 $emailPlainRows[] = "\n" . "Total" . " " .$Total. " " .$openedTotal. " " .$closedTotal;
 $emailHTMLRows[] = "<tr class='totalRow'><td>Total</td><td>$Total</td><td>$openedTotal</td><td>$closedTotal</td></tr>";
 }?>

</table>

<div id='legend_link'>
 <a href="#" onclick="toggle_visibility('legend');" />
  <span>Show/Hide Legend</span>
 </a><br /><br /> 

<div id="legend"> 
 <b>Department</b><br /> 
 Department tickets are assigned to.<br /><br /> 

 <b>Staff</b>
 <br /> Staff member the ticket is assigned to.<br /><br /> 

 <b>Assigned</b><br /> 
 Number of tickets assigned to this department or staff during the given time period.<br /><br /> 

 <b>Tickets Open</b><br /> 
 Number of tickets that are PRESENTLY open that were created during the given time period.<br /><br /> 

 <b>Tickets Created</b><br /> 
 Number of tickets that were created during given time period.<br /><br /> 

 <b>Tickets Closed</b><br /> 
 Number of tickets that were closed during the given time period.<br /><br /> 

 <b>Days/Hours to Resolution</b><br /> 
 Amount of time in hours or days from ticket creation to ticket being closed.
</div>

<?

 // If we've elected to email the report to someone, do it now.
 if(isset($_POST['email'])){ require_once('reports_includes/emailReport.php'); }


fclose($fh); // Close up our csv file
}else{
       echo "<div class='section-header'><span class='section-content'>No data for the selected report</span></div>" ;
     }

}
} // Close our while loop for getting report options 

mysql_close(); 
require_once(STAFFINC_DIR.'footer.inc.php');





?>

