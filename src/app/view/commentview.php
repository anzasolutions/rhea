<?php

namespace app\view;

use core\system\session\SessionUser;
use core\system\template\Template;

use app\util\PageIndex;
use app\util\TimeAgo;

class CommentView extends MenuView
{
    public function produceComments()
    {
        $template = new Template('comments', 'comments');
        $template->formAction = $this->url->build('comment', 'addAjax');
        $template->avatar = $this->getAvatar($this->getUser());
        $template->link = $this->url->build('profile', $this->getUser()->getUsername());
        $template->type = $this->url->getController();
        $template->id = $this->url->getParameter(0);
        if ($this->values->hasKey('comments'))
        {
            $template->comments = $this->makeComments();
            $template->pageIndex = PageIndex::makeIndex($this->commentPageNumbers, 1);
        }
        $template->commentsNo = $this->values->commentsNo;
        return $template;
    }

    private function makeComments()
    {
        $comments = null;
        foreach ($this->comments as $comment)
        {
            $comments .= $this->makeComment($comment);
        }
        return $comments;
    }

    private function makeComment($comment)
    {
        $template = new Template('comment', 'comments');
        $template->avatar = $this->getAvatar($comment->getUser());
        $template->link = $this->url->build('profile', $comment->getUser()->getUsername());
        $template->name = $comment->getUser()->getUsername();
        $template->comment = $comment->getContent();
        $template->date = TimeAgo::ago(strtotime($comment->getDate()));
        return $template;
    }

    private function getUser()
    {
        return SessionUser::getInstance()->getUser();
    }

    // FIXME: echo ?????
    public function addAjax()
    {
        if ($this->values->hasKey('comments'))
        {
            echo $this->makeComments();
        }
    }
}

?>