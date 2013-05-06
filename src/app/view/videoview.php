<?php

namespace app\view;

use core\system\session\SessionUser;
use core\system\template\Template;
use core\util\DateFormat;
use core\util\TimeConverter;

use app\model\Video;
use app\util\PageIndex;
use app\util\TimeAgo;
use app\view\CommentView;

class VideoView extends MenuView
{
    protected function videos()
    {
        $this->prepareDisplay();
    }

    protected function user()
    {
        $this->prepareDisplay(1);
    }

    private function prepareDisplay($parameter = 0)
    {
        $this->checkErrors();
        $this->assembleVideos('videos', 'thumbnail');
        $this->preparePageIndex('videoPageNumbers', $parameter);
        $this->template->formAction = $this->url->build('video', 'loadMore');
        $this->template->show('videos-paging', $this->url->getController());
    }

    private function assembleVideos($key, $template)
    {
        if ($this->values->hasKey($key))
        {
            $this->template->$key = null;
            foreach ($this->$key as $video)
            {
                $this->template->$key .= $this->{'get'.$template}($video);
            }
        }
    }

    private function assembleVideosForDisplay($key, $template)
    {
        $videos = '';
        if ($this->values->hasKey($key))
        {
            $this->template->$key = null;
            foreach ($this->$key as $video)
            {
                $videos .= $this->{'get'.$template}($video);
            }
        }
        return $videos;
    }

    private function getThumbnail(Video $video)
    {
        $template = new Template('thumbnail', 'video');
        $template->image = $video->getThumbnail();
        $template->link = $this->url->build('video', 'show', $video->getId());
        $template->title = $video->getTitle();
        return $template;
    }

    private function preparePageIndex($key, $parameterNumber = 0)
    {
        if ($this->values->hasKey($key))
        {
            $this->template->pageIndex = PageIndex::makeIndex($this->$key, $parameterNumber);
        }
    }

    /**
     * @MenuItem
     * @MenuBundle = "link.header.video.add"
     */
    protected function add()
    {
        $template = new FormWrapper('link.header.video.add');
        $this->checkErrors($template);
        $template->render();
    }

    protected function show()
    {
        $this->checkErrors();

        $commentView = new CommentView();
        $this->template->comments = $commentView->produceComments();

        $video = $this->video;

        $this->template->videoObject = $this->getVideoObject($video);
        $this->template->title = $video->getTitle();
        $this->template->duration = TimeConverter::formatToMinutes($video->getDuration());
        $this->template->date = DateFormat::convert($video->getAdded(), 'j F Y');
        $this->template->link = $this->url;
        $this->template->profileLink = $this->url->build('profile', $video->getUser()->getUsername());
        $this->template->username = $video->getUser()->getUsername();
        $this->template->views = $video->getViews();
        $this->template->time = DateFormat::convert($video->getAdded(), 'G:i');
        $this->template->timeAgo = TimeAgo::ago(strtotime($video->getAdded()));
        $this->template->commentsNo = $this->values->commentsNo;
        $this->template->avatar = $this->getAvatar($video->getUser());
        $this->template->link = $this->url->build('profile', $video->getUser()->getUsername());
        
        $this->assembleVideos('moreRandom', 'recommended');
        $this->template->show($this->url->getActionPath());
    }

    private function getVideoObject(Video $video)
    {
        $template = new Template($video->getVideoType()->getName(), 'video');
        $template->sourceId = $video->getSourceId();
        return $template;
    }

    private function getRecommended(Video $video)
    {
        $template = new Template('recommended', 'video');
        $template->image = $video->getThumbnail();
        $template->link = $this->url->build('video', 'show', $video->getId());
        $template->title = $this->shortenTitle($video->getTitle());
        $template->name = $video->getUser()->getUsername();
        $template->length = TimeConverter::formatToMinutes($video->getDuration());
        $template->views = $video->getViews();
        return $template;
    }
    
    private function shortenTitle($title)
    {
        return strlen($title) > 70 ? substr($title, 0, 70).'...' : $title;
    }

    // FIXME: to be completed
    protected function search()
    {
        $this->checkErrors();
        $this->assembleVideos('videos', 'thumbnail');
        $this->preparePageIndex('videoPageNumbers', 1);
        $this->template->show($this->url->getActionPath('videos'));

        $this->prepareDisplay();
    }

    protected function loadMore()
    {
        //FIXME: echo??????
        echo $this->assembleVideosForDisplay('videos', 'thumbnail');
    }
}

?>