<?php

namespace core\system;

/**
 * Wraps around log4php Logger class.
 * @author anza
 */
class Logger
{
    private static $log;
    
    /**
     * Static call should pass __CLASS__ as parameter.
     * Instance call should pass either object instance.
     * @param string | object $name
     */
    public static function getLogger($name)
    {
        if (!self::$log)
        {
            if (is_object($name))
            {
                $name = get_class($name);
            }
            
            require_once 'log4php/Logger.php';
            \Logger::configure('log4php.xml');
            
            self::$log = \Logger::getLogger($name);
        }
        return self::$log;
    }
}

?>