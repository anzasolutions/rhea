<?php

namespace core\db\common;

use core\db\Result;

abstract class AbstractResult implements Result
{
    protected $result;

    public function __construct($result)
    {
        $this->result = $result;
    }
}

?>