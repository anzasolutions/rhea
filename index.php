<?php

require_once 'src/core/config/config.php';
require_once 'src/app/config/config.php';
require_once 'src/core/system/ClassLoader.php';

core\system\ClassLoader::load();
core\system\Dispatcher::dispatch();

?>
