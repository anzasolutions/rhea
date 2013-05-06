<?php

namespace core\db\constant;

class FetchType
{
    private function __construct() {}

    const EAGER = 'eager';
    const LAZY  = 'lazy';
    const NONE  = 'none';
}

?>