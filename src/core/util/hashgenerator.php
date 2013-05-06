<?php

namespace core\util;

/**
 * Generate different types of hash.
 * @author anza
 * @since 04-12-2010
 */
class HashGenerator
{
    const MD5 = 'md5';
    const SHA1 = 'sha1';
    const SHA256 = 'sha256';
    const SHA512 = 'sha512';
    
    public static function generate($method, $string)
    {
        return hash($method, $string);
    }
}

?>