<?php

namespace app\model;

use core\util\DateFormat;

/**
 * @Entity
 */
class Comment
{
    private $id;
    private $content;

    /**
     * @CommentType
     * @Fetch = "eager"
     */
    private $commentType;
    private $typeId;
    private $date;

    /**
     * @User
     * @Fetch = "eager"
     */
    private $user;
    private $voteup;
    private $votedown;
    private $spam;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getCommentType()
    {
        return $this->commentType;
    }

    public function setCommentType($commentType)
    {
        $this->commentType = $commentType;
    }

    public function getTypeId()
    {
        return $this->typeId;
    }

    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date = null)
    {
        if ($date == null)
        {
            $date = DateFormat::getNow();
        }
        $this->date = $date;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getVoteUp()
    {
        return $this->voteup;
    }

    public function setVoteUp($voteup)
    {
        $this->voteup = $voteup;
    }

    public function getVoteDown()
    {
        return $this->votedown;
    }

    public function setVoteDown($votedown)
    {
        $this->votedown = $votedown;
    }

    public function getSpam()
    {
        return $this->spam;
    }

    public function setSpam($spam)
    {
        $this->spam = $spam;
    }
}

?>