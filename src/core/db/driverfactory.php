<?php

namespace core\db;

use core\util\XMLLoader;

final class DriverFactory
{
    private static $driver;

    /**
     * Read DB config and get requested DB driver.
     * XML configured driver is returned by default.
     * @param string $type
     * @return Driver
     */
    public static function createDefault()
    {
        if (self::$driver == null)
        {
            $config = XMLLoader::toContainer(DB_FILE);
            $type = $config->driver;
            $driver = 'core\db\\'.$type.'\\'.$type.'Driver';
            self::$driver = new $driver($config);
        }
        return self::$driver;
    }
}

?>