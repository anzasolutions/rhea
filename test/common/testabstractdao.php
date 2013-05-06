<?php

namespace common;

use core\dao\AbstractDAO;

class TestAbstractDAO extends AbstractDAO
{
    public function __construct($type)
    {
        $this->type = $type;
    }
}

?>