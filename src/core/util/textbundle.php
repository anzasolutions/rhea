<?php

namespace core\util;

use php\util\Properties;

/**
 * Provide text for specific locale
 * @author anza
 * @version 20120729
 */
class TextBundle
{
    private static $instance;

    private $bundle;

    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $file = PATH_ROOT . '/web/resources/messages.properties';
        $properties = new Properties();
        $this->bundle = $properties->load($file);
    }

    public function getText($key)
    {
        if (!array_key_exists($key, $this->bundle))
        {
            return $key;
        }

        $text = $this->bundle[$key];
        $params = func_get_args();
        array_shift($params);
        foreach ($params as $paramKey => $paramValue)
        {
            $text = str_replace('{'.$paramKey.'}', $paramValue, $text);
        }
        return $text;
    }
}

?>