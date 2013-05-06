<?php

namespace core\system;

use core\system\session\Session;

class Context
{
    const SESSION = 'Session';
    const REQUEST = 'Request';
    const APPLICATION = 'Application';

    public static function getCurrent()
    {
        return Session::getInstance()->isStarted() ? self::SESSION : self::REQUEST;
    }
}

?>