<?php

namespace app\service\video\service;

use core\util\XMLLoader;

abstract class AbstractVS
{
    protected $id;
    protected $url;
    protected $xml;
    protected $feed;
    protected $content;
    protected $title;
    protected $thumbnail;
    protected $duration;

    public function __construct($url)
    {
        $this->url = $url;
        $this->process();
    }

    protected function process()
    {
        $this->parse();
        $this->read();
        $this->verify();
        $this->extract();
    }

    private function read()
    {
        $this->content = file_get_contents($this->xml);
        $this->load();
    }

    protected function load()
    {
        $this->feed = XMLLoader::loadString($this->content);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    public function getDuration()
    {
        return $this->duration;
    }
}

?>