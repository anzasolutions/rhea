<?php

namespace core\system\container;

use php\util\AbstractContainer;

/**
 * Hold values transferres between layers.
 * @author anza
 * @version 14-04-2011
 */
class Values extends AbstractContainer
{
    private static $instance;

    private function __construct() {}

    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
}

?>