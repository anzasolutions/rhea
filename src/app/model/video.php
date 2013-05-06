<?php

namespace app\model;

use core\util\DateFormat;

/**
 * @Entity
 */
class Video
{
    private $id;

    /**
     * @User
     * @Fetch = "eager"
     */
    private $user;
    private $sourceId;
    private $added;
    private $rate;
    private $views;

    /**
     * @VideoType
     * @Fetch = "eager"
     */
    private $videoType;
    private $title;
    private $thumbnail;
    private $duration;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getSourceId()
    {
        return $this->sourceId;
    }

    public function setSourceId($sourceId)
    {
        $this->sourceId = $sourceId;
    }

    public function getAdded()
    {
        return $this->added;
    }

    public function setAdded($added = null)
    {
        if ($added == null)
        {
            $added = DateFormat::getNow();
        }
        $this->added = $added;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    public function getViews()
    {
        return $this->views;
    }

    public function setViews($views)
    {
        $this->views = $views;
    }

    public function getVideoType()
    {
        return $this->videoType;
    }

    public function setVideoType($videoType)
    {
        $this->videoType = $videoType;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }
}

?>