<?php

namespace core\db\common;

use core\db\Driver;

abstract class AbstractDriver implements Driver
{
    protected $connection;
    protected $result;
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
        $this->connect();
    }

    public function getResult()
    {
        return $this->result;
    }

    public function __destruct()
    {
        $this->disconnect();
    }
}

?>