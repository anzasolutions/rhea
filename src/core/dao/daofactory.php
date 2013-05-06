<?php

namespace core\dao;

class DAOFactory
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {}

    // TODO: have to handle incorrect $type!
    public function getDAO($type)
    {
        $dao = 'app\dao\\'.$type.'DAO';
        return new $dao($type);
    }
}

?>