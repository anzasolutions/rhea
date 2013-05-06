<?php

define('PATH_ROOT', getcwd());
define('URL_APP', str_replace('index.php', '', 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']));
define('URL_STATIC', URL_APP);
define('DEBUG_SQL', false);

?>