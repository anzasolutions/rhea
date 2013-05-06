<?php

namespace core\util;

class Navigator
{
    private $header;
    
    public function __construct()
    {
        $this->header = new Header();
    }
    
    public function redirectTo($location = null)
    {
        if ($location == null)
        {
            $location = URL_APP;
        }
        else if (is_object($location))
        {
            $controller = strtolower(substr(strrchr($location, '\\'), 1, -10));
            $location = URL_APP . $controller;
        }
        else if (!self::isUrl($location))
        {
            $location = URL_APP . $location;
        }
        $this->header->header($location);
    }
    
    private function isUrl($location)
    {
        return strpos($location, 'http://') !== false;
    }
}

?>