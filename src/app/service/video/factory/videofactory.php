<?php

namespace app\service\video\factory;

use core\system\session\SessionUser;

use app\model\Video;
use app\service\video\service\VideoServiceDetector;

class VideoFactory
{
    public static function createFrom(VideoServiceDetector $detector)
    {
        $user = SessionUser::getInstance()->getUser();

        $video = new Video();
        $video->setSourceId($detector->getId());
        $video->setUser($user);
        $video->setAdded(null);
        $video->setVideoType($detector->getType());
        $video->setTitle($detector->getTitle());
        $video->setThumbnail($detector->getThumbnail());
        $video->setDuration($detector->getDuration());
        return $video;
    }
}

?>