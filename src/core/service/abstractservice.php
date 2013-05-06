<?php

namespace core\service;

use core\dao\DAOPool;

abstract class AbstractService implements Service
{
    protected $dao;

    public function __construct()
    {
        $this->dao = DAOPool::getInstance();
    }
}

?>