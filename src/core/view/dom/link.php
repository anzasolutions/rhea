<?php

namespace core\view\dom;

class Link extends DOMObject
{
    private $link;
    private $value;
    private $title;

    public function __construct($link, $value)
    {
        $this->link = $link;
        $this->value = $value;
    }

    public function addTitle($title)
    {
        $this->title = ' title="' . $title . '"';
        return $this;
    }

    public function __toString()
    {
        return '<a href="' . $this->link . '"' . $this->id . $this->name . $this->title . $this->class . $this->style . '>' . $this->value . '</a>' . "\n";
    }
}

?>