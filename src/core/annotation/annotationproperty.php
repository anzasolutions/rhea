<?php

namespace core\annotation;

class AnnotationProperty extends AnnotationObject
{
    public function __construct(\ReflectionProperty $property)
    {
        $this->object = $property;
    }
}

?>