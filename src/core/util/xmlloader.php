<?php

namespace core\util;

use php\io\FileNotFoundException;
use php\util\Container;

/**
 * Load and parse XML file.
 * @author anza
 * @version 03-10-2010
 */
class XMLLoader
{
    /**
     * Load and parse XML file.
     * @param string $file
     * @throws FileNotFoundException
     * @return object SimpleXMLElement
     */
    public static function load($file)
    {
        if (file_exists($file))
        {
            return simplexml_load_file($file);
        }
        throw new FileNotFoundException($file);
    }

    /**
     * Load and parse remote XML.
     * @param string $file
     * @return object SimpleXMLElement
     */
    public static function loadUrl($file)
    {
        return simplexml_load_file($file);
    }

    /**
     * Load and parse given XML string.
     * @param string $xml
     * @return object SimpleXMLElement
     */
    public static function loadString($xml)
    {
        return simplexml_load_string($xml);
    }

    /**
     * Map parsed XML to Container type.
     * @param string $file
     * @return Container
     */
    public static function toContainer($file)
    {
        $xml = self::load($file);
        $config = new Container();
        foreach ($xml as $child)
        {
            $key = $child->getName();
            $config->$key = (string) $child;
        }
        return $config;
    }
}

?>