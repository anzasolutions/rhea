<?php

// this part belongs to Travis CI setup
$autoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoload))
{
	require_once $autoload;
}
// this is a setup for Eclipse's MakeGood
else
{
	set_include_path(dirname(__FILE__).'/../src/'.PATH_SEPARATOR.get_include_path());
	set_include_path(dirname(__FILE__).'/../test/'.PATH_SEPARATOR.get_include_path());
	set_include_path(dirname(__FILE__).'/../lib/'.PATH_SEPARATOR.get_include_path());
	spl_autoload_extensions('.php');
	spl_autoload_register('spl_autoload');
}

?>