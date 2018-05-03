<?php

 $email_image_name = $report_images_dir.date('U').".png";
 $myPicture->render("$email_image_name");

 $email_image_src = getConfig('helpdesk_url').'scp/'.$email_image_name;
 $helpdesk_url = getConfig('helpdesk_url');

 $to = $_POST['email'];
 $subject = "[REPORT] $report_type - $report_range";

 $boundary = uniqid('np');

 $headers = "MIME-Version: 1.0\r\n";
 $headers .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\r\n";
 $headers .= 'From: osTicket Reports <YOUR_ADDRESS@YOUR_DOMAIN>';

 $message = "This is a MIME encoded message.";

 $message .= "\r\n\r\n--" . $boundary . "\r\n";
 $message .= "Content-type: text/plain;charset=utf-8\r\n\r\n";
 $message .= "For best results, view this email in HTML.\r\n\r\n";
 // $message .= $emailReportHeader;
 foreach($emailPlainRows as $emailPlainRow){
  $message .= $emailPlainRow;
 }

 $message .= "\r\n\r\n--" . $boundary . "\r\n";
 $message .= "Content-type: text/html;charset=utf-8\r\n\r\n";
 $message .= <<<EMAIL
<link rel="stylesheet" href="${helpdesk_url}scp/reports_css/style.css" type="text/css" />
<div class="section-header-email">
 <span class="section-title-email">$report_type: $report_range</span>
</div>
<div class='section-content-email'>
 <img src='$email_image_src'>
</div>

<table id="hor-minimalist-b" class="table-email"> 
EMAIL;

foreach($emailHTMLRows as $emailHTMLRow){
  $message .= $emailHTMLRow;
 }

$message .= "</table>";

 $message .= "\r\n\r\n--" . $boundary . "--";

    mail($to, $subject, stripslashes($message), $headers);
