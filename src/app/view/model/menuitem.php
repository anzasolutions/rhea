<?php

namespace app\view\model;

class MenuItem
{
    private $link;
    private $label;
    private $show;
    
    public function getLink()
    {
        return $this->link;
    }
    
    public function setLink($link)
    {
        $this->link = $link;
    }
    
    public function getLabel()
    {
        return $this->label;
    }
    
    public function setLabel($label)
    {
        $this->label = $label;
    }
    
    public function getshow()
    {
        return $this->show;
    }
    
    public function setShow($show)
    {
        $this->show = $show;
    }
}

?>