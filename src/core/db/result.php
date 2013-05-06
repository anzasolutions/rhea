<?php

namespace core\db;

interface Result
{
    public function fetch($method = null);

    public function getSize();

    public function flush();
}

?>