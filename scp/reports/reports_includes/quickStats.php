<div class='section-header'>
 <span class='section-title'>Quick Stats</span>
</div>

<div class='section-content'>

  <div class='sub-section'>
   <div class='sub-header'>
    <span class='sub-title'>Average time tickets remained open</span>
   </div>
  <div class='sub-content'>
   <?
    $thisyear = include("timecalc_currentyear.php");
    $lastyear = include("timecalc_lastyear.php");
    $alltime  = include("timecalc_alltime.php");
   ?>
  </div>
 </div>

 <div class='sub-section'>
  <div class='sub-header'>
   <span class='sub-title'>Average Response Time</span>
  </div>
 <div class='sub-content'>
    <?
     $avgrespontime = include("avgrespontime_currentyear.php");
     $avgrespontime = include("avgrespontime_lastyear.php");
     $avgrespontime = include("avgrespontime_alltime.php");
    ?>
   </div>
  </div>
 
 <div class='sub-section'>
  <div class='sub-header'>
   <span class='sub-title'># of Tickets Opened</span>
  </div>
 <div class='sub-content'>
   <?
    $ticketsthisyear = include("tickets_thisyear.php");
    $ticketslastyear = include("tickets_lastyear.php");
    $ticketslastyear = include("tickets_alltime.php");
   ?>
  </div>
 </div>
<div style='clear:both;'></div>

</div>
