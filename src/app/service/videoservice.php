<?php

namespace app\service;

use php\util\Container;

use core\db\exception\NoResultException;
use core\service\AbstractService;
use core\service\ServiceException;

use app\service\video\factory\VideoFactory;
use app\service\video\service\VideoServiceDetector;
use app\model\Video;
use app\util\RandomNumbers;

class VideoService extends AbstractService
{
    private static $wallSize = 42;

    public function add($link)
    {
        $detector = new VideoServiceDetector($link);
        $video = VideoFactory::createFrom($detector);
        $this->dao->video->save($video);
    }

    public function getVideo($id)
    {
        $video = $this->dao->video->findById($id);
        $this->updateViews($video);
        return $video;
    }

    private function updateViews(Video $video)
    {
        $views = $video->getViews();
        $video->setViews(++$views);
        $this->dao->video->save($video);
    }

    public function getVideoPageNumbers()
    {
        $videosNo = $this->dao->video->count();
        return ceil($videosNo / self::$wallSize);
    }

    public function getVideosRange($start)
    {
        try
        {
            $limit = self::$wallSize;
            $position = $this->getCurrentWallPage($start);
            return $this->dao->video->findRange($position, $limit);
        }
        catch (NoResultException $e)
        {
            throw new ServiceException();
        }
    }

    private function getCurrentWallPage($start)
    {
        $span = self::$wallSize;
        $position = 0;
        if ($start != null)
        {
            $total = $start * $span;
            $position = $total - $span;
        }
        return $position;
    }

    public function getUserVideoPageNumbers($username)
    {
        $videosNo = $this->dao->video->countByUserId($username);
        return ceil($videosNo / self::$wallSize);
    }

    public function getUserVideosRange($username, $start)
    {
        try
        {
            $limit = self::$wallSize;
            $position = $this->getCurrentWallPage($start);
            return $this->dao->video->findUserVideosRange($username, $position, $limit);
        }
        catch (NoResultException $e)
        {
            throw new ServiceException();
        }
    }

    public function getUserRandomVideos($username)
    {
        $limit = self::$wallSize;
        $position = 0;

        $videos = $this->dao->video->findUserVideosRange($username, $position, $limit);
        $randomNumbers = new RandomNumbers($position, sizeof($videos) - 1, 7);
        $randoms = $randomNumbers->generate();
        
        $randomVideos = new Container();
        foreach ($randoms as $random)
        {
            $randomVideos->add($videos[$random]);
        }
        return $randomVideos;
    }

    public function getVideosRangeByTitle($title, $start)
    {
        try
        {
            $limit = self::$wallSize;
            $position = $this->getCurrentWallPage($start);
            return $this->dao->video->findLikeTitle($title, $position, $limit);
        }
        catch (NoResultException $e)
        {
            throw new ServiceException();
        }
    }
}

?>