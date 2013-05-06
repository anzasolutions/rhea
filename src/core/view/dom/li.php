<?php

namespace core\view\dom;

class Li extends DOMObject
{
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
        return $this;
    }

    public function __toString()
    {
        return '<li ' . $this->id . $this->class . $this->style . '>' . $this->content . '</li>' . "\n";
    }
}

?>