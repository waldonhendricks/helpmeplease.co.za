        </div>
    </div>
    <footer class="footer ">
        <div class="container">
            <div class="copyright pull-left">
               MaterialOs Theme for Osticket Based on <a href="https://www.creative-tim.com/product/material-kit" target="_blank">MaterialKit</a>
            </div>
            <div class="copyright pull-right">
                &copy;
                <?php echo date('Y'); ?> <?php echo (string) $ost->company ?: 'osTicket.com'; ?> - All rights reserved. 
                <a id="Designed by" href="https://waldonhendricks.github.io/" target="_blank"><?php echo __('Designed by'); ?></a>
            </div>
        </div>
    </footer>
<div id="overlay"></div>
<div id="loading">
    <h4><?php echo __('Please Wait!');?></h4>
    <p><?php echo __('Please wait... it will take a second!');?></p>
</div>
<?php
if (($lang = Internationalization::getCurrentLanguage()) && $lang != 'en_US') { ?>
    <script type="text/javascript" src="ajax.php/i18n/<?php
        echo $lang; ?>/js"></script>
<?php } ?>
<script type="text/javascript">
    getConfig().resolve(<?php
        include INCLUDE_DIR . 'ajax.config.php';
        $api = new ConfigAjaxAPI();
        print $api->client(false);
    ?>);
</script>

<script type="text/javascript">
var LHCChatOptions = {};
LHCChatOptions.opt = {widget_height:340,widget_width:300,popup_height:520,popup_width:500};
(function() {
var _l = '';var _m = document.getElementsByTagName('meta');var _cl = '';for (i=0; i < _m.length; i++) {if ( _m[i].getAttribute('http-equiv') == 'content-language' ) {_cl = _m[i].getAttribute('content');}}if (document.documentElement.lang != '') _l = document.documentElement.lang;if (_cl != '' && _cl != _l) _l = _cl;if (_l == undefined || _l == '') {_l = '';} else {_l = _l[0].toLowerCase() + _l[1].toLowerCase(); if ('eng' == _l) {_l = ''} else {_l = _l + '/';}}
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
var referrer = (document.referrer) ? encodeURIComponent(document.referrer.substr(document.referrer.indexOf('://')+1)) : '';
var location  = (document.location) ? encodeURIComponent(window.location.href.substring(window.location.protocol.length)) : '';
po.src = '//enquiries.cput.ac.za/lhc_web/index.php/'+_l+'chat/getstatus/(click)/internal/(position)/bottom_right/(ma)/br/(check_operator_messages)/true/(top)/350/(units)/pixels/(leaveamessage)/true/(department)/1/(survey)/2?r='+referrer+'&l='+location;
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
</script>

<script type="text/javascript">
var LHCChatboxOptions = {hashchatbox:'empty',identifier:'default',status_text:'Chat to the IT academic Department'};
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = '//enquiries.cput.ac.za/lhc_web/index.php/chatbox/getstatus/(position)/middle_right/(top)/300/(units)/pixels/(width)/300/(height)/300/(chat_height)/220/(scm)/true';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
</script>

<script type="text/javascript">
var LHCVotingOptions = {status_text:'Help us to grow'};
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = '//enquiries.cput.ac.za/lhc_web/index.php/questionary/getstatus/(position)/middle_right/(top)/400/(units)/pixels/(width)/300/(height)/300';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
</script>

<script type="text/javascript">
var LHCFAQOptions = {status_text:'FAQ',url:'replace_me_with_dynamic_url',identifier:''};
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = '//enquiries.cput.ac.za/lhc_web/index.php/faq/getstatus/(position)/middle_right/(top)/450/(units)/pixels';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
</script>

 <!--   Core JS Files   -->
    <script src="<?php echo ROOT_PATH; ?>assets/MaterialOs/js/core/jquery.min.js"></script>
    <script src="<?php echo ROOT_PATH; ?>assets/MaterialOs/js/core/popper.min.js"></script>
    <script src="<?php echo ROOT_PATH; ?>assets/MaterialOs/js/bootstrap-material-design.js"></script>
    <!--  Plugin for Date Time Picker and Full Calendar Plugin  -->
    <script src="<?php echo ROOT_PATH; ?>assets/MaterialOs/js/plugins/moment.min.js"></script>
    <!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
    <script src="<?php echo ROOT_PATH; ?>assets/MaterialOs/js/plugins/bootstrap-datetimepicker.min.js"></script>
    <!--	Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="<?php echo ROOT_PATH; ?>assets/MaterialOs/js/plugins/nouislider.min.js"></script>
    <!-- Material Kit Core initialisations of plugins and Bootstrap Material Design Library -->
    <script src="<?php echo ROOT_PATH; ?>assets/MaterialOs/js/material-kit.js?v=2.0.2"></script>
</body>
</html>
