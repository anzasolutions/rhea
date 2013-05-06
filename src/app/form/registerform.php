<?php

namespace app\form;

use core\form\AbstractForm;
use core\util\HashGenerator;

/**
 * @ValidationUnit = "app\form\constant\ValidationRules"
 */
class RegisterForm extends AbstractForm
{
    /**
     * @ValidationRule = "NAME"
     */
    protected $username;
    
    /**
     * @ValidationRule
     */
    protected $email;
    
    /**
     * @ValidationRule = "PASS"
     */
    protected $password;

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return HashGenerator::generate(HashGenerator::MD5, $this->password);
    }
}

?>