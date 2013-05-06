<?php

namespace core\view\dom;

class Select extends DOMObject
{
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function __toString()
    {
        return '<select ' . $this->id . $this->name . $this->class . $this->style . $this->event . '>' . $this->content . '</select>' . "\n";
    }
}

?>