<?php

namespace app\util;

class TimeAgo
{
    /**
     * This can be used for comments and other from of communication to tell
     * the time ago instead of the exact time which might not be correct
     * to some one in another time zone.
     * The function only uses unix time stamp like the result of time();
     * @author Chris Coyier http://css-tricks.com/snippets/php/time-ago-function/
     * @param int $time
     * @return string time converted to a time ago string
     */
    public static function ago($time)
    {
        $periods = array('second', 'minute', 'hour', 'day', 'week', 'month', 'year', 'decade');
        $lengths = array('60','60','24','7','4.35','12','10');

        $now = time();

        $difference = $now - $time;
        $tense = 'ago';

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++)
        {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1)
        {
            $periods[$j] .= 's';
        }

        return "$difference $periods[$j] ago";
    }
}

?>