<?php

namespace core\view\dom;

abstract class DOMObject
{
    protected $id;
    protected $name;
    protected $class;
    protected $style;
    protected $event;

    public function addId($id)
    {
        $this->id = ' id="' . $id . '"';
        return $this;
    }

    public function addName($name)
    {
        $this->name = ' name="' . $name . '"';
        return $this;
    }

    public function addClass($class)
    {
        $this->class = ' class="' . $class . '"';
        return $this;
    }

    public function addStyle($style)
    {
        $this->style = ' style="' . $style . '"';
        return $this;
    }

    public function addEvent($type, $action)
    {
        $this->event = ' ' . $type . '="' . $action . '"';
        return $this;
    }
}

?>