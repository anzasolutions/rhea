<?php

namespace app\controller;

use core\controller\Controller;
use core\controller\ControllerFactory;
use core\service\ServiceException;

use app\service\video\exception\VideoException;

/**
 * @Session
 */
class VideoController extends Controller
{
    /**
     * @Invocable
     */
    protected function index()
    {
        $this->setAction('videos');
    }

    /**
     * @Invocable
     */
    protected function videos()
    {
        $this->getVideosRange();
        $this->videoPageNumbers = $this->service->video->getVideoPageNumbers();
    }

    private function getVideosRange()
    {
        try
        {
            $this->videos = $this->service->video->getVideosRange($this->url->getParameter(0));
        }
        catch (ServiceException $e)
        {
            $this->error = $this->bundle->getText('video.message.error.no.videos');
        }
    }

    /**
     * @Invocable
     */
    protected function user()
    {
        $username = $this->url->getParameter(0);
        if ($username == null)
        {
            $this->redirectToError();
        }
        $this->getUserVideosRange($username);
        $this->videoPageNumbers = $this->service->video->getUserVideoPageNumbers($username);
    }

    private function getUserVideosRange($username)
    {
        try
        {
            $this->videos = $this->service->video->getUserVideosRange($username, $this->url->getParameter(1));
        }
        catch (ServiceException $e)
        {
            $this->log->error('User has no videos', $e);
            $this->error = $this->bundle->getText('video.message.error.user.has.no.videos');
        }
    }

    /**
     * @Invocable
     * @Form = "newvideo"
     */
    protected function add($form)
    {
        try
        {
            $link = $form->getLink();
            $this->service->video->add($link);
            $this->redirectTo('video');
        }
        catch (VideoException $e)
        {
            $this->error = $this->bundle->getText('form.validation.video.url.incorrect');
        }
    }

    /**
     * @Invocable
     */
    protected function show()
    {
        if (!$this->url->hasParameters())
        {
            $this->redirectToError();
        }
        
        $videoId = intval($this->url->getParameter(0));
        if ($videoId == 0)
        {
            $this->redirectToError();
        }
        
        // TODO: shouldn't this be in try-catch block?
        $this->video = $this->service->video->getVideo($videoId);
        $this->moreRandom = $this->service->video->getUserRandomVideos($this->video->getUser()->getUsername());
        $factory = new ControllerFactory();
        $factory->create('comment')->getComments();
    }

    /**
     * @Invocable
     */
    protected function search()
    {
        if ($this->request->hasKey('search'))
        {
            $name = preg_replace('/[^A-Za-z0-9 ]/', '', $this->request->search);
            $url = $this->url->build($this->url->getController(), $this->url->getAction(), $name);
            $this->redirectTo($url);
        }

        $this->name = $this->url->getParameter(0);

        if ($this->name == null)
        {
            $this->redirectTo('video');
        }

        try
        {
            $this->videos = $this->service->video->getVideosRangeByTitle($this->name, $this->url->getParameter(1));
        }
        catch (ServiceException $e)
        {
            $this->error = $this->bundle->getText('video.message.error.not.found', $this->name);
        }
    }

    /**
     * @Invocable
     * @WebMethod
     * @Form = "loadmore"
     */
    protected function loadMore($form)
    {
        $this->url->setParameters($form->getLast());
        $this->videos();
    }
}

?>