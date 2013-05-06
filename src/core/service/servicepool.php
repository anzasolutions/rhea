<?php

namespace core\service;

use php\util\Container;

use core\constant\Separator;

/**
 * Keep Service instances for reuse.
 * @author anza
 * @since 2012-10-07
 */
class ServicePool
{
    private static $instance;

    private $pool;

    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->pool = new Container();
    }

    public function __get($name)
    {
        if (!$this->pool->hasKey($name))
        {
            $service = $this->getService($name);
            $this->pool->$name = new $service();
        }
        return $this->pool->$name;
    }
    
    private function getService($name)
    {
        return 'app\service\\'.$name.'Service';
    }
}

?>