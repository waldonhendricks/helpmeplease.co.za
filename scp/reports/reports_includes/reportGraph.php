<?php

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
if($_POST['dateRange'] == 'timePeriod'){ require_once('timePeriods.php'); }

// Specified time range
if($_POST['dateRange'] == 'timeRange'){ require_once('timeRange.php'); }

// Setup groupings
require_once('groups.php');

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
