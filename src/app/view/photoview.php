<?php

namespace app\view;

use core\system\template\Template;
use core\util\DateFormat;

use app\model\Photo;
use app\util\PageIndex;

class PhotoView extends MenuView
{
    protected function photos()
    {
        $this->checkErrors();

        if ($this->values->hasKey('photos'))
        {
            $this->template->photos = '';
            foreach ($this->photos as $photo)
            {
                $this->template->photos .= $this->getThumbnail($photo);
            }
        }

        if ($this->values->hasKey('photoPageNumbers'))
        {
            $this->template->pageIndex = PageIndex::makeIndex($this->photoPageNumbers);
        }

        $this->template->show($this->url->getActionPath());
    }

    private function getThumbnail(Photo $photo)
    {
        $template = new Template('thumbnail', 'photo');
        $template->image = URL_PHOTOS . $photo->getUser()->getId() . '/thumbs/' . $photo->getFile();
        $template->link = $this->url->build('photo', 'show', $photo->getId());
        return $template;
    }

    /**
     * @MenuItem
     * @MenuBundle = "link.header.photo.add"
     */
    protected function add()
    {
        $template = new FormWrapper('link.header.photo.add');
        $this->checkErrors($template);
        $template->render();
    }

    protected function user()
    {
        $this->photos();
    }

    protected function show()
    {
        $this->checkErrors();

        $commentView = new CommentView();
        $this->template->comments = $commentView->produceComments();

        //		$this->template->title = $this->video->getTitle();
        $this->template->date = DateFormat::convert($this->photo->getAdded(), 'j F Y');
        $this->template->link = $this->url;

        $this->template->profileLink = $this->url->build('profile', $this->photo->getUser()->getUsername());
        $this->template->username = $this->photo->getUser()->getUsername();
        $this->template->photo = URL_PHOTOS . $this->photo->getUser()->getId() . '/big/' . $this->photo->getFile();
        if ($this->values->photoOlder)
        {
            $this->template->link = $this->url->build('photo', 'show', $this->photoOlder->getId());
        }

        $this->template->show($this->url->getActionPath());
    }
}

?>