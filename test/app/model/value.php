<?php

namespace app\model;

/**
 * @Entity
 */
class Value
{
    private $id = 0;
    private $value = '';
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function setValue($value)
    {
        $this->value = $value;
    }
}

?>