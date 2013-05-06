<?php

namespace app\form;

use core\form\AbstractForm;

/**
 * @ValidationUnit = "app\form\constant\ValidationRules"
 */
class NewCategoryForm extends AbstractForm
{
    /**
     * @ValidationRule = "TEXT"
     */
    protected $name;

    public function getName()
    {
        return $this->name;
    }
}

?>