<?php

namespace core\util;

/**
 * Generate random password.
 * @author anza
 * @version 18-06-2011
 */
class PasswordGenerator
{
    /**
     * Calculates 32-digit hexadecimal md5 hash
     * @param int $length
     * @return string
     */
    public static function generate($length = 6)
    {
        return substr(md5(rand().rand()), 0, $length);
    }
}

?>