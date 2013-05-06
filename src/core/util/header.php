<?php

namespace core\util;

/**
 * Wrapper of PHP's header function.
 * @author anza
 * @since 11-11-2012
 */
class Header
{
    public function header($string, $replace = null, $http_response_code = null)
    {
        header("Location: " . $string, $replace, $http_response_code);
    }
}

?>