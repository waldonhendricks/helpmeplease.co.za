<?php
/*********************************************************************
    index.php

    Helpdesk landing page. Please customize it to fit your needs.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/
require('client.inc.php');

require_once INCLUDE_DIR . 'class.page.php';

$section = 'home';
require(CLIENTINC_DIR.'header.inc.php');
?>
<div class="section text-center">
    <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
            <?php if($cfg && ($page = $cfg->getLandingPage()))
                echo $page->getBodyWithImages();
            else
                echo  '<h2 class="title">'.__('Welcome to the Support Center').'</h2>';
            ?>
        </div>
    </div>
</div>
<?php include CLIENTINC_DIR.'templates/sidebar.tmpl.php'; ?>
        <?php
        if ($cfg && $cfg->isKnowledgebaseEnabled()) { ?>
    <div class="section text-center">
        <div class="row">
            <div class="col-md-8 ml-auto mr-auto">
            <h2 class="text-center title"><?php echo __('Search our knowledge base'); ?></h2>
            <form method="get" action="kb/faq.php">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="material-icons">search</i>
                    </span>
                </div>
                <input type="hidden" name="a" value="search"/>
                <input type="text" name="q" class="form-control" placeholder="<?php echo __('Search our knowledge base'); ?>">
            </div>
                <button type="submit" class="btn btn-primary"><?php echo __('Search'); ?></button>
            </form>
            </div>
        </div>
    </div>
            <?php
        }?>
<div>
<?php
if($cfg && $cfg->isKnowledgebaseEnabled()){
    //FIXME: provide ability to feature or select random FAQs ??
?>
<div class="section text-center">
    <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
    <?php
    $cats = Category::getFeatured();
    if ($cats->all()) { ?>
        <h2 class="text-center title"><?php echo __('Featured Knowledge Base Articles'); ?></h2>
    <?php
    }?>        
    <?php foreach ($cats as $C) { ?>
        <div class="card card-nav-tabs">
            <i class="material-icons">folder_open</i><h4 class="card-header card-header-info"><?php echo $C->getName(); ?></h4>
            <div class="card-body">
                <?php foreach ($C->getTopArticles() as $F) { ?>
                    <h4 class="card-title"><a href="<?php echo ROOT_PATH;
                    ?>kb/faq.php?id=<?php echo $F->getId(); ?>"><?php
                    echo $F->getQuestion(); ?></a></h4>
                    <p class="card-text"><?php echo $F->getTeaser(); ?></p>
                <?php } ?>    
            </div>
        </div>
    <?php
    }?>
        </div>
    </div>
</div>
<?php }
?>
</div>      
<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>
