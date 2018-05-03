<?php
if(!defined('OSTCLIENTINC')) die('Access Denied');

$email=Format::input($_POST['lemail']?$_POST['lemail']:$_GET['e']);
$ticketid=Format::input($_POST['lticket']?$_POST['lticket']:$_GET['t']);

if ($cfg->isClientEmailVerificationRequired())
    $button = __("Email Access Link");
else
    $button = __("View Ticket");
?>
<div class="section section-contacts">
    <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
            <h2 class="text-center title"><?php echo __('Check Ticket Status'); ?></h2>
            <h4 class="text-center description"><?php
                echo __('Please provide your email address and a ticket number.');
                if ($cfg->isClientEmailVerificationRequired())
                    echo ' '.__('An access link will be emailed to you.');
                else
                    echo ' '.__('This will sign you in to view your ticket.');
                ?>
            </h4>
            <br></br>
            <form class="contact-form" action="login.php" method="post" id="clientLogin">
                <?php csrf_token(); ?>
                    <?php if($errors['login']) { ?>
                    <div class="alert alert-danger">
                        <div class="container">
                            <div class="alert-icon">
                                <i class="material-icons">error_outline</i>
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="material-icons">clear</i></span>
                            </button>
                            <?php echo Format::htmlchars($errors['login']); ?>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" ><?php echo __('Email Address'); ?></label>
                                <input id="email" placeholder="<?php echo __('e.g. john.doe@osticket.com'); ?>" type="text"
                                name="lemail" size="30" value="<?php echo $email; ?>" class="nowarn form-control">
                            </div>
                        </div>    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ticketno"><?php echo __('Ticket Number'); ?></label>
                                <input id="ticketno" type="text" name="lticket" placeholder="<?php echo __('e.g. 051243'); ?>"
                                size="30" value="<?php echo $ticketid; ?>" class="nowarn form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 ml-auto mr-auto text-center">
                            <input class="btn btn-primary btn-raised" type="submit" value="<?php echo $button; ?>">
                            <br></br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 ml-auto mr-auto text-center">
                        <?php if ($cfg && $cfg->getClientRegistrationMode() !== 'disabled') { ?>
                            <?php echo __('Have an account with us?'); ?>
                            <a href="login.php"><?php echo __('Sign In'); ?></a> <?php
                            if ($cfg->isClientRegistrationEnabled()) { ?>
                                <?php echo sprintf(__('or %s register for an account %s to access all your tickets.'),
                                '<a href="account.php?do=create">','</a>');
                            }
                        }?>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
<div class="section text-center">
    <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
        <?php
        if ($cfg->getClientRegistrationMode() != 'disabled'
            || !$cfg->isClientLoginRequired()) {
            echo sprintf(
            __("If this is your first time contacting us or you've lost the ticket number, please %s open a new ticket %s"),
                '<a href="open.php">','</a>');
        } ?>
        </div>
    </div>
</div>
