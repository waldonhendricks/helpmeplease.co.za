<div class='section-header'>
 <span class='section-title'>Report Criteria</span>
</div>

<div class='section-content'>

 <!--Load the AJAX API-->
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>

<form method="POST" name="reportForm" > <table name="formTable" id='reportForm'>
  <tr>
   <td>Select date range</td>
  <td>
   <input type="radio" name="dateRange" value="timePeriod" <?if($_POST['dateRange']=='timePeriod'){echo "selected";}?> checked />
   <select name="range" onclick="document.reportForm.dateRange[0].checked=true">
    <option value="today" <?if($_POST['range']=='today'){echo "selected";}?>>Today</option>
    <option value="yesterday" <?if($_POST['range']=='yesterday'){echo "selected";}?>>Yesterday</option>
    <option value="thisMonth" <?if($_POST['range']=='thisMonth'){echo "selected";}?>>This Month</option>
    <option value="lastMonth" <?if($_POST['range']=='lastMonth'){echo "selected";}?>>Last Month</option>
    <option value="lastThirty" <?if($_POST['range']=='lastThirty'){echo "selected";}?>>Last 30 days</option>
    <option value="thisWeek" <?if($_POST['range']=='thisWeek'){echo "selected";}?>>This Week (Sun-Sat)</option>
    <option value="lastWeek" <?if($_POST['range']=='lastWeek'){echo "selected";}?>>Last Week (Sun-Sat)</option>
    <option value="thisBusWeek" <?if($_POST['range']=='thisBusWeek'){echo "selected";}?>>This business week (Mon-Fri)</option>
    <option value="lastBusWeek" <?if($_POST['range']=='lastBusWeek'){echo "selected";}?>>Last business week (Mon-Fri)</option>
    <option value="thisYear" <?if($_POST['range']=='thisYear'){echo "selected";}?>>This year</option>
    <option value="lastYear" <?if($_POST['range']=='lastYear'){echo "selected";}?>>Last year</option>
    <option value="allTime" <?if($_POST['range']=='allTime'){echo "selected";}?>>All time</option>
   </select>
  </td>
  <td><input type="radio" name="dateRange" value="timeRange" <?if($_POST['dateRange']=='timeRange'){echo "checked";}?>/></td>
  <td>From <input type="text" name="fromDate" value="<?if($_POST['fromDate']!=''){echo $_POST['fromDate'];}else{echo date("Y-m-d");}?>" onclick="document.reportForm.dateRange[1].checked=true"/>
      To <input type="text" name="toDate" value="<?if($_POST['toDate']!=''){echo $_POST['toDate'];}else{echo date("Y-m-d");}?>"     onclick="document.reportForm.dateRange[1].checked=true"/></td>
 </tr>
 <tr>
  <td>Report Type</td>
  <td>
   <select name="type" id='reportSelect'>
    <option value="tixPerDept" <?if($_POST['type']=='tixPerDept'){echo "selected";}?>>Tickets per Department</option>
    <option value="tixPerDay" <?if($_POST['type']=='tixPerDay'){echo "selected";}?>>Tickets per Day</option>
    <option value="tixPerMonth" <?if($_POST['type']=='tixPerMonth'){echo "selected";}?>>Tickets per Month</option>
    <option value="tixPerStaff" <?if($_POST['type']=='tixPerStaff'){echo "selected";}?>>Tickets per Staff</option>
    <? if(getConfig('ostversion') == '1.6 ST'){?>
    <option value="tixPerTopic" <?if($_POST['type']=='tixPerTopic'){echo "selected";}?>>Tickets per Help Topic</option>
    <?}?>
    <option value="repliesPerStaff" <?if($_POST['type']=='repliesPerStaff'){echo "selected";}?>>Replies per Staff</option>
    <option value="tixPerClient" <?if($_POST['type']=='tixPerClient'){echo "selected";}?>>Tickets per Client</option>
   </select>
  </td>
 </tr>
 <tr>
  <td>Email (optional)</td><td><input type='text' name='email' id='emailInput' /></td>
 </tr>
 <tr>
  <td align="right" colspan="4">
   <input type="submit" name="submit" class="button"/><input type="reset" name="reset" class='button'/>
  </td>
</table>
</form>
</div>
