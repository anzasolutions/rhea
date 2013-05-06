<?php

namespace core\form\validation;

use core\system\container\Request;

class FormValidator
{
    /**
     * Check whether value is empty or doesn't match regex rule.
     * @author anza
     * @param string $value to be checked
     * @param string $name what name during exception
     * @param string $rule regex rule to check
     * @throws FormValidationException
     */
    public static function validate($value, $name, $rule)
    {
        if (empty($value) || !preg_match($rule, $value))
        {
            Request::getInstance()->replace($name, null);
            throw new FormValidationException($name);
        }
        	
    }

    /**
     * Validate provided year, month and day.
     * Convert string parameters to integers.
     * @author anza
     * @param string $year
     * @param string $month
     * @param string $day
     * @throws FormValidationException
     */
    public static function validateDate($year, $month, $day)
    {
        settype($month, "int");
        settype($day, "int");
        settype($year, "int");
        if (!checkdate($month, $day, $year))
        {
            throw new FormValidationException('date');
        }
    }
}

?>