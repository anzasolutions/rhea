<?php

namespace php\util;

abstract class AbstractContainer implements \IteratorAggregate
{
    protected $values = array();

    public function getIterator()
    {
        return new \ArrayIterator($this->values);
    }

    public function hasKey($key)
    {
        return isset($this->values[$key]);
    }

    public function hasValue($value)
    {
        return in_array($value, $this->values);
    }

    public function remove($key)
    {
        if (!$this->hasKey($key))
        {
            throw new NoSuchElementException('No element with key ' . $key);
        }
        unset($this->values[$key]);
        return !$this->hasKey($key);
    }

    public function pop()
    {
        return array_pop($this->values);
    }

    public function getValues()
    {
        return array_values($this->values);
    }
    
    public function replace($key, $value)
    {
        if (!$this->hasKey($key))
        {
            throw new NoSuchElementException('No element with key ' . $key);
        }
        $this->values[$key] = $value;
        return $this->hasValue($value);
    }

    public function clear()
    {
        return $this->values = array();
    }

    public function size()
    {
        return sizeof($this->values);
    }

    public function add($value)
    {
        return $this->values[] = $value;
    }

    public function isEmpty()
    {
        return empty($this->values);
    }
    
    public function __set($key, $value)
    {
        $this->values[$key] = $value;
    }

    public function __get($key)
    {
        return $this->hasKey($key) ? $this->values[$key] : null;
    }
}

?>