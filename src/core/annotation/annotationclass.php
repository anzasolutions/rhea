<?php

namespace core\annotation;

class AnnotationClass extends AnnotationObject
{
    public function __construct($name)
    {
        $this->object = new \ReflectionClass($name);
    }

    public function getProperty($name, $annotation = null)
    {
        $property = $this->object->getProperty($name);
        $property = new AnnotationProperty($property);
        if ($annotation && !$property->hasAnnotation($annotation))
        {
            return;
        }
        return $property;
    }

    public function getProperties($annotation = null)
    {
        $results = array();
        $properties = $this->object->getProperties();
        foreach ($properties as $property)
        {
            $property = new AnnotationProperty($property);
            if ($annotation && !$property->hasAnnotation($annotation))
            {
                continue;
            }
            $results[] = $property;
        }
        return $results;
    }

    public function getMethod($name, $annotation = null)
    {
        $method = $this->object->getMethod($name);
        $method = new AnnotationMethod($method);
        if ($annotation && !$method->hasAnnotation($annotation))
        {
            return;
        }
        return $method;
    }

    public function getMethods($annotation = null)
    {
        $result = array();
        $methods = $this->object->getMethods();
        foreach ($methods as $method)
        {
            $method = new AnnotationMethod($method);
            if ($annotation && !$method->hasAnnotation($annotation))
            {
                continue;
            }
            $result[] = $method;
        }
        return $result;
    }
}

?>