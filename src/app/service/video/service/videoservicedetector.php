<?php

namespace app\service\video\service;

use core\constant\Separator;
use core\dao\DAOPool;

use app\service\video\exception\VideoException;

class VideoServiceDetector
{
    private $url;
    private $type;
    private $service;
    private $title;
    private $thumbnail;
    private $duration;

    public function __construct($url)
    {
        $this->url = $url;
        $this->detect($url);
    }

    public function detect($url)
    {
        $host = parse_url($this->url, PHP_URL_HOST);
        $videoTypes = DAOPool::getInstance()->videoType->findAll();
        foreach ($videoTypes as $type)
        {
            if (stristr($host, $type->getName()))
            {
                $this->type = $type;
                $this->initializeService();
                return;
            }
        }
        throw new VideoException();
    }

    private function initializeService()
    {
        $serviceName = __NAMESPACE__ . Separator::BACKSLASH . $this->type->getName() . 'VS';
        $this->service = new $serviceName($this->url);
    }

    public function getId()
    {
        return $this->service->getId();
    }

    public function getType()
    {
        return $this->type;
    }

    public function getTitle()
    {
        return $this->service->getTitle();
    }

    public function getThumbnail()
    {
        return $this->service->getThumbnail();
    }

    public function getDuration()
    {
        return $this->service->getDuration();
    }
}

?>