<?php

namespace core\annotation;

use php\util\Container;

abstract class AnnotationObject
{
    protected $object;

    public function getValueOf($annotation)
    {
        $pattern = "/^.+?\@" . $annotation . " = \"(.*)\"/is";
        if (preg_match($pattern, $this->object->getDocComment(), $result) > 0)
        {
            return trim($result[1]);
        }
    }

    public function getValuesOf($annotation)
    {
        $value = $this->getValueOf($annotation);
        $values = explode(',', $value);
        return array_map('trim', $values);
    }

    public function getValueMapOf($annotation)
    {
        $valueMap = array();
        $values = $this->getValuesOf($annotation);
        foreach ($values as $value)
        {
            $keyValue = explode('=', $value);
            $keyValue = array_map('trim', $keyValue);
            $valueMap[$keyValue[0]] = $keyValue[1];
        }
        return $valueMap;
    }

    public function hasAnnotation($annotation)
    {
        $pattern = '/@' . $annotation . '/';
        return preg_match($pattern, $this->object->getDocComment()) > 0;
    }
    
    public function getAnnotations()
    {
        $pattern = "/@(.*)/";
        preg_match_all($pattern, $this->object->getDocComment(), $matches);
        $results = new Container();
        foreach ($matches[1] as $result)
        {
            $results->add(trim($result));
        }
        return $results;
    }

    public function hasAnnotations()
    {
        return $this->getAnnotations()->isEmpty();
    }

    public function hasOneOfAnnotations()
    {
        $annotations = $this->getAnnotations();
        foreach (func_get_args() as $annotation)
        {
            if ($annotations->hasValue($annotation))
            {
                return true;
            }
        }
    }

    public function getObject()
    {
        return $this->object;
    }

    public function getName()
    {
        return $this->object->getName();
    }

    public function getShortName()
    {
        return $this->object->getShortName();
    }
}

?>