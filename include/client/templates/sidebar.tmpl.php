<?php
$BUTTONS = isset($BUTTONS) ? $BUTTONS : true;
?>
<div class="features">
    <div class="row">
        <?php if ($BUTTONS) { ?>
            <?php
            if ($cfg->getClientRegistrationMode() != 'disabled'
                || !$cfg->isClientLoginRequired()) { ?>
				
				</div>
<div class="features">
    <div class="row"><?php
        $faqs = FAQ::getFeatured()->select_related('category')->limit(5);
        if ($faqs->all()) { ?>
            <div class="col">
                <div class="card card-nav-tabs">
                    <h4 class="card-header card-header-info"><?php echo __('Featured Questions'); ?></h4>
                    <div class="card-body text-center">
                        <ul class="list-group list-group-flush">
                            <?php   foreach ($faqs as $F) { ?>
                                <li class="list-group-item"><a href="<?php echo ROOT_PATH; ?>kb/faq.php?id=<?php
                                    echo urlencode($F->getId());
                                    ?>"><?php echo $F->getLocalQuestion(); ?></a></li>
                            <?php   } ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php
        }
        $resources = Page::getActivePages()->filter(array('type'=>'other'));
            if ($resources->all()) { ?>
            <div class="col">
                <div class="card card-nav-tabs">
                    <h4 class="card-header card-header-info"><?php echo __('Other Resources'); ?></h4>
                    <div class="card-body text-center">
                        <ul class="list-group list-group-flush">
                            <?php   foreach ($resources as $page) { ?>
                                <li class="list-group-item"><a href="<?php echo ROOT_PATH; ?>pages/<?php echo $page->getNameAsSlug();
                                    ?>"><?php echo $page->getLocalName(); ?></a></li>
                            <?php   } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
             }
        ?>
    </div>
				
                <div class="col">
                    <div class="card card-nav-tabs">
                        <h4 class="card-header card-header-info"><?php echo __('Open a New Ticket');?></h4>
                        <div class="card-body text-center">
                            <h4 class="card-title">Click here to open your enquiry</h4>
                            <p class="card-text">Please provide as much detail as possible so we can best assist you,use a valid CPUT student number and contact number.</p>
                            <div class="row">
                                <div class="col-md-4 ml-auto mr-auto text-center">
                                    <a href="open.php" class="btn btn-primary btn-raised"><?php
                                     echo __('Open a New Ticket');?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="col">
                <div class="card card-nav-tabs">
                    <h4 class="card-header card-header-warning"><?php echo _('Check Ticket Status');?></h4>
                    <div class="card-body text-center">
                        <h4 class="card-title">Click here to track your enquiry</h4>
                        <p class="card-text">We provide archives and history of all your current and past student requests complete with responses.</p>
                        <div class="row">
                            <div class="col-md-4 ml-auto mr-auto text-center">
                                <a href="view.php" class="btn btn-primary btn-raised"><?php
                                echo __('Check Ticket Status');?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>