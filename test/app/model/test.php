<?php

namespace app\model;

/**
 * @Entity
 */
class Test
{
    private $id = 0;

    /**
     * @Value
     * @Fetch = "eager"
     */
    private $value = '';
    
    public function __construct($id = null)
    {
        $this->id = $id;
    }
    
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