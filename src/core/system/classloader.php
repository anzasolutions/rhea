<?php

namespace core\system;

class ClassLoader
{
    public static function load()
    {
        self::addPath('lib');
        self::addPath('src');
        spl_autoload_extensions('.php,.class.php');
        spl_autoload_register('spl_autoload');
    }
    
    public static function addPath($path)
    {
        set_include_path(PATH_ROOT.'/'.$path.'/'.PATH_SEPARATOR.get_include_path());
    }
}

?>