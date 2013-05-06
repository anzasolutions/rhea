<?php

namespace core\system\container;

use core\db\exception\IncorrectTypeException;

/**
 * Hold info about image file obtained
 * from $_FILE post request
 * @author anza
 * @version Nov 25, 2011
 */
class ImageRequestFile
{
    private $file;

    public function __construct(RequestFile $file)
    {
        if (!$this->isImage($file))
        {
            throw new IncorrectTypeException("not an image!");
        }
        $this->file = $file;
    }

    public function getName()
    {
        return $this->file->getName();
    }

    public function getType()
    {
        return $this->file->getType();
    }

    public function getSize()
    {
        return $this->file->getSize();
    }

    public function getTmpName()
    {
        return $this->file->getTmpName();
    }

    public function getError()
    {
        return $this->file->getError();
    }

    private function isImage(RequestFile $file)
    {
        $type = $file->getType();
        return $type == "image/jpeg" || $type == "image/pjpeg" || $type == "image/gif" || $type == "image/png" || $type == "image/x-png";
    }
}

?>