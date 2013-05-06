<?php

namespace core\util;

class TimeConverter
{
    /**
     * Format given seconds to a form of minutes and seconds.
     * http://forums.digitalpoint.com/showthread.php?t=531022&p=4983270#post4983270
     * @author anza
     * @param unknown_type $seconds
     * @return string
     */
    public static function formatToMinutes($seconds)
    {
        $pattern = '%02.2d:%02.2d';
        return sprintf($pattern, floor($seconds / 60), $seconds % 60);
    }
}

?>