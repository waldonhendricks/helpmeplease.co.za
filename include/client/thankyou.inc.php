<?php
if(!defined('OSTCLIENTINC') || !is_object($ticket)) die('Kwaheri rafiki!');
//Please customize the message below to fit your organization speak!
?>
<div style="margin:5px 100px 100px 0;">
    <?php echo Format::htmlchars($ticket->getName()); ?>,<br>
    <p>
     Thank you for contacting us.<br>
     A CPUT Student Query request has been created and a representative from the ICT Department will be getting back to you shortly if necessary.
	 Please remember use your Ticket ID# for any enquiries regarding your Query.
</p>
          
    <?php if($cfg->autoRespONNewTicket()){ ?>
    <p>An email with the ticket ID number has been sent to <b><?php echo $ticket->getEmail(); ?></b>.
        You'll need the ticket number along with your email to log on and view status and progress online. 
    </p>
    <p>
     If you wish to send additional comments or information regarding same issue, please follow the instructions on the email.
    </p>
    <?php } ?>
    <p> ICT ADMIN::IS Administration </p>
</div>
