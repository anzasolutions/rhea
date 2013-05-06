<?php

namespace app\model;

use core\util\DateFormat;

/**
 * @Entity
 */
class Photo
{
    private $id;

    /**
     * @User
     * @Fetch = "eager"
     */
    private $user;
    private $file;
    private $added;

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

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
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
}

?>