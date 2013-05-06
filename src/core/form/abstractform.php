<?php

namespace core\form;

use core\annotation\Annotation;
use core\annotation\AnnotationClass;
use core\form\validation\FormValidator;
use core\form\validation\ValidationRuleException;
use core\system\container\Request;

/**
 * Basic form object class.
 * @author anza
 * @version 12-06-2011
 */
abstract class AbstractForm
{
    const PROCESS = 'process';

    protected $request;
    private $fields;

    public function __construct()
    {
        $this->request = Request::getInstance();
        if (!$this->isSent())
        {
            return;
        }
        $this->populate();
        $this->bind();
        $this->validate();
    }

    /**
     * Bind values from form to FO.
     */
    protected function bind()
    {
        foreach ($this->fields as $field => $rule)
        {
            $this->$field = $this->request->$field;
        }
    }

    /**
     * Validate binded values.
     */
    protected function validate()
    {
        foreach ($this->fields as $field => $rule)
        {
            FormValidator::validate($this->$field, $field, $rule);
        }
    }

    /**
     * Check whether form has been explicitly sent.
     * Submit button must be set with specific name.
     * @return boolean
     */
    public function isSent()
    {
        return $this->request->hasKey(self::PROCESS);
    }
    
    private function populate()
    {
        $class = new AnnotationClass($this);
        
        // TODO: maybe instead of not nice getValueOf should be getAnnotation?
        
        $validationUnit = $class->getValueOf(Annotation::VALIDATION_UNIT);
        $validationUnitClass = new \ReflectionClass($validationUnit);
        $properties = $class->getProperties(Annotation::VALIDATION_RULE);
        foreach ($properties as $property)
        {
            $field = $property->getName();
            $validationRuleValue = $property->getValueOf(Annotation::VALIDATION_RULE);
            if (empty($validationRuleValue))
            {
                $validationRuleValue = strtoupper($field);
            }
            
            if (!$validationUnitClass->hasConstant($validationRuleValue))
            {
                throw new ValidationRuleException('Given validation rule ' . $validationUnit . '::' . $validationRuleValue . ' doesn\'t exists');
            }
            $rule = $validationUnitClass->getConstant($validationRuleValue);
            $this->fields[$field] = $rule;
        }
    }
}

?>