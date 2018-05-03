<?php
$title=($cfg && is_object($cfg) && $cfg->getTitle())
    ? $cfg->getTitle() : 'osTicket :: '.__('Support Ticket System');
$signin_url = ROOT_PATH . "login.php"
    . ($thisclient ? "?e=".urlencode($thisclient->getEmail()) : "");
$signout_url = ROOT_PATH . "logout.php?auth=".$ost->getLinkToken();

header("Content-Type: text/html; charset=UTF-8");
if (($lang = Internationalization::getCurrentLanguage())) {
    $langs = array_unique(array($lang, $cfg->getPrimaryLanguage()));
    $langs = Internationalization::rfc1766($langs);
    header("Content-Language: ".implode(', ', $langs));
}
?>
<!DOCTYPE html>
<html<?php
if ($lang
        && ($info = Internationalization::getLanguageInfo($lang))
        && (@$info['direction'] == 'rtl'))
    echo ' dir="rtl" class="rtl"';
if ($lang) {
    echo ' lang="' . $lang . '"';
}
?>>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo Format::htmlchars($title); ?></title>
    <meta name="description" content="Enquiry support platform">
    <meta name="keywords" content="osTicket, Customer support system, support ticket system">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/osticket.css?9ae093d" media="screen"/>
    <!--<link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/theme.css?9ae093d" media="screen"/>-->
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/print.css?9ae093d" media="print"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>scp/css/typeahead.css?9ae093d"
         media="screen" />
    <link type="text/css" href="<?php echo ROOT_PATH; ?>css/ui-lightness/jquery-ui-1.10.3.custom.min.css?9ae093d"
        rel="stylesheet" media="screen" />
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/thread.css?9ae093d" media="screen"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/redactor.css?9ae093d" media="screen"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/font-awesome.min.css?9ae093d"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/flags.css?9ae093d"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/rtl.css?9ae093d"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/select2.min.css?9ae093d"/>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/MaterialOs/css/material-kit.css?v=2.0.2">
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-1.11.2.min.js?9ae093d"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-ui-1.10.3.custom.min.js?9ae093d"></script>
    <script src="<?php echo ROOT_PATH; ?>js/osticket.js?9ae093d"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/filedrop.field.js?9ae093d"></script>
    <script src="<?php echo ROOT_PATH; ?>scp/js/bootstrap-typeahead.js?9ae093d"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor.min.js?9ae093d"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-plugins.js?9ae093d"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-osticket.js?9ae093d"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/select2.min.js?9ae093d"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/fabric.min.js?9ae093d"></script>
    <?php
    if($ost && ($headers=$ost->getExtraHeaders())) {
        echo "\n\t".implode("\n\t", $headers)."\n";
    }

    // Offer alternate links for search engines
    // @see https://support.google.com/webmasters/answer/189077?hl=en
    if (($all_langs = Internationalization::getConfiguredSystemLanguages())
        && (count($all_langs) > 1)
    ) {
        $langs = Internationalization::rfc1766(array_keys($all_langs));
        $qs = array();
        parse_str($_SERVER['QUERY_STRING'], $qs);
        foreach ($langs as $L) {
            $qs['lang'] = $L; ?>
        <link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>?<?php
            echo http_build_query($qs); ?>" hreflang="<?php echo $L; ?>" />
<?php
        } ?>
        <link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"
            hreflang="x-default" />
<?php
    }
    ?>
</head>
<body class="profile-page ">
    <nav class="navbar navbar-color-on-scroll navbar-transparent    fixed-top  navbar-expand-lg " color-on-scroll="100" id="sectionsNav">
        <div class="container">
            <div class="navbar-translate">
                <a class="navbar-brand" id="logo" href="<?php echo ROOT_PATH; ?>index.php" title="<?php echo __('Support Center'); ?>">
                    <?php echo $ost->getConfig()->getTitle(); ?>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <?php
                    if($nav){ ?>
                        <?php
                        if($nav && ($navs=$nav->getNavLinks()) && is_array($navs)){
                            foreach($navs as $name =>$nav) {
                            echo sprintf('<li class="nav-item"><a class="nav-link %s %s" href="%s">%s</a></li>%s',$nav['active']?'active':'',$name,(ROOT_PATH.$nav['href']),$nav['desc'],"\n");
                            }
                        } ?>
                    <?php
                    }?>
                    <?php
                        if ($thisclient && is_object($thisclient) && $thisclient->isValid()
                        && !$thisclient->isGuest()) {?>
                            <li class="dropdown nav-item">
                                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <i class="material-icons">perm_identity</i><?php echo Format::htmlchars($thisclient->getName()).'&nbsp;|';?>
                                </a>
                                <div class="dropdown-menu dropdown-with-icons">
                                    <a href="<?php echo ROOT_PATH; ?>profile.php" class="dropdown-item"><?php echo __('Profile'); ?></a> |
                                    <a href="<?php echo ROOT_PATH; ?>tickets.php" class="dropdown-item"><?php echo sprintf(__('Tickets <b>(%d)</b>'), $thisclient->getNumTickets()); ?></a> -
                                    <a href="<?php echo $signout_url; ?>" class="dropdown-item"><?php echo __('Sign Out'); ?></a>
                                </div>
                            </li>
                        <?php
                        } elseif($nav) {
                            if ($cfg->getClientRegistrationMode() == 'public') { ?>
                                <li class="dropdown nav-item">
                                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                        <i class="material-icons">perm_identity</i><?php echo __('Guest User'); ?>
                                    </a>
                                <?php
                            }
                            if ($thisclient && $thisclient->isValid() && $thisclient->isGuest()) { ?>
                                <div class="dropdown-menu dropdown-with-icons">
                                    <a href="<?php echo $signout_url; ?>" class="dropdown-item"><?php echo __('Sign Out'); ?></a><
                                </div>
                                </li><?php
                            }
                            elseif ($cfg->getClientRegistrationMode() != 'disabled') { ?>
                                <div class="dropdown-menu dropdown-with-icons">
                                    <a href="<?php echo $signin_url; ?>"><?php echo __('Sign In'); ?></a>
                                </div>
                                </li>
                            <?php
                            }
                        } ?>
                        <?php
                        if (($all_langs = Internationalization::getConfiguredSystemLanguages())
                            && (count($all_langs) > 1)
                            ) {?>
                                <li class="dropdown nav-item">
                                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                                        <i class="material-icons">language</i>
                                    </a>
                                    <div class="dropdown-menu dropdown-with-icons">
                                        <?php 
                                        $qs = array();
                                        parse_str($_SERVER['QUERY_STRING'], $qs);
                                        foreach ($all_langs as $code=>$info) {
                                            list($lang, $locale) = explode('_', $code);
                                            $qs['lang'] = $code;
                                            ?>
                                            <a class="flag flag-<?php echo strtolower($locale ?: $info['flag'] ?: $lang); ?>"
                                            href="?<?php echo http_build_query($qs);
                                            ?>" title="<?php echo Internationalization::getLanguageDescription($code); ?>">&nbsp;</a>
                                        <?php } ?>
                                    </div>
                                </li>
                            <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <!--Custom Parallax header -->
    <div class="page-header header-filter clear-filter red-filter" data-parallax="true" style="background-image: url('<?php echo ROOT_PATH; ?>assets/MaterialOs/img/sky.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-md-8 ml-auto mr-auto">
                    <div class="brand">
                        <h1 class="text-center">CPUT</h1>
				<h2 class="text-center">Department of Information Technology</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End-->
    <div class="main main-raised">
        <div id="container" class="container">
         <?php if($errors['err']) { ?>
            <div class="alert alert-danger">
                <div class="container">
                    <div class="alert-icon">
                        <i class="material-icons">error_outline</i>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="material-icons">clear</i></span>
                    </button>
                    <?php echo $errors['err']; ?>
                </div>
            </div>
         <?php }elseif($msg) { ?>
            <div class="alert alert-info">
                <div class="container">
                    <div class="alert-icon">
                        <i class="material-icons">info_outline</i>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="material-icons">clear</i></span>
                    </button>
                    <?php echo $msg; ?>
                </div>
            </div>
         <?php }elseif($warn) { ?>
            <div class="alert alert-warning">
                <div class="container">
                    <div class="alert-icon">
                        <i class="material-icons">warning</i>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="material-icons">clear</i></span>
                    </button>
                    <?php echo $warn; ?>
                </div>
            </div>
         <?php } ?>
