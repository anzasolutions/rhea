<?php

namespace php\util;

class Container extends AbstractContainer
{
    public function __construct(array $values = null)
    {
        if ($values != null)
        {
            $this->values = $values;
        }
    }
}

?>