<?php

namespace app\form;

use core\form\AbstractForm;

/**
 * @ValidationUnit = "app\form\constant\ValidationRules"
 */
class FindFriendForm extends AbstractForm
{
    /**
     * @ValidationRule = "FULLNAME"
     */
    protected $name;
    
    public function getName()
    {
        return $this->name;
    }
}

?>