<?php

namespace app\form;

use core\form\AbstractForm;

/**
 * @ValidationUnit = "app\form\constant\ValidationRules"
 */
class RemoveCategoryForm extends AbstractForm
{
    /**
     * @ValidationRule = "DIGIT"
     */
    protected $category;
    
    public function getCategory()
    {
        return $this->category;
    }
}

?>