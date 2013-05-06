<?php

namespace app\form;

use core\form\AbstractForm;

/**
 * @ValidationUnit = "app\form\constant\ValidationRules"
 */
class NewProductForm extends AbstractForm
{
    /**
     * @ValidationRule = "TEXT"
     */
    protected $name;
    
    /**
     * @ValidationRule = "TEXT"
     */
    protected $description;
    
    /**
     * @ValidationRule = "DIGIT"
     */
    protected $price;
    
    /**
     * @ValidationRule = "DIGIT"
     */
    protected $category;

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getCategory()
    {
        return $this->category;
    }
}

?>