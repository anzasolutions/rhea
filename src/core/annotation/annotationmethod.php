<?php

namespace core\annotation;

class AnnotationMethod extends AnnotationObject
{
    public function __construct(\ReflectionMethod $method)
    {
        $this->object = $method;
    }
}

?>