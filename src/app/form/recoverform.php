<?php

namespace app\form;

use core\form\AbstractForm;

/**
 * @ValidationUnit = "app\form\constant\ValidationRules"
 */
class RecoverForm extends AbstractForm
{
    /**
     * @ValidationRule
     */
    protected $email;

    public function getEmail()
    {
        return $this->email;
    }
}

?>