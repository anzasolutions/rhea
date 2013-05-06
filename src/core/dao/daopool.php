<?php

namespace core\dao;

use php\util\Container;

/**
 * Keep DAO instances for reuse.
 * @version 2012-07-08
 */
class DAOPool
{
    private static $instance;

    private $pool;
    private $factory;

    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->pool = new Container();
        $this->factory = DAOFactory::getInstance();
    }

    public function __get($type)
    {
        if (!$this->pool->hasKey($type))
        {
            $dao = $this->factory->getDAO($type);
            $this->pool->$type = $dao;
        }
        return $this->pool->$type;
    }
}

?>