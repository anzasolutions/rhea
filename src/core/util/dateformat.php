<?php

namespace core\util;

/**
 * Helper providing date tools.
 * @author anza
 * @since 22-11-2010
 */
class DateFormat
{
    const DEFAULT_FORMAT = 'Y-m-d H:i:s';

    public static function getNow($format = null)
    {
        $date = new \DateTime();
        if ($format == null)
        {
            $format = self::DEFAULT_FORMAT;
        }
        return $date->format($format);
    }

    public static function convert($date, $format = null)
    {
        if ($format == null)
        {
            $format = self::DEFAULT_FORMAT;
        }
        $date = new \DateTime($date);
        return $date->format($format);
    }
}

?>