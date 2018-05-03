<?php

  // This gets defined in main.inc.php but we need it before main.inc.php gets included
  // Actually we need it to better find main.inc.php :(
  define('ROOT_DIR',str_replace('\\\\', '/', realpath(dirname(__FILE__))).'/');
