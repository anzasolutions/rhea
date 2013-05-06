<?php

namespace app\util;

use php\io\File;

use core\constant\FileSuffix;
use core\system\session\SessionUser;

/**
 * Transform provided image file
 * for collection of user photos.
 * @author anza
 * @version 25-11-2011
 */
class PhotoTransformer
{
    const MEMORY_LIMIT = '512M';
    
    private $type;
    private $tmpName;
    private $name;
    private $source;

    public function __construct($type, $tmpName, $name)
    {
        $this->type = $type;
        $this->tmpName = $tmpName;
        $this->name = $name;
        $this->setMemory(self::MEMORY_LIMIT);
        $this->createSource();
    }

    public function setMemory($size)
    {
        ini_set('memory_limit', $size);
    }

    private function createSource()
    {
        $name = $this->tmpName;

        switch ($this->type)
        {
            case 'image/jpeg':
                $this->source = imagecreatefromjpeg($name);
                return;
            case 'image/pjpeg':
                $this->source = imagecreatefromjpeg($name);
                return;
            case 'image/gif':
                $this->source = imagecreatefromgif($name);
                return;
            case 'image/x-png':
                $this->source = imagecreatefrompng($name);
                return;
            case 'image/png':
                $this->source = imagecreatefrompng($name);
                return;
        }
    }

    public function resize($maxWidth, $maxHeight, $output)
    {
        $name = $this->name . FileSuffix::JPG;

        $tmpImage = $this->tmpName;
        imagejpeg($this->source, $tmpImage, 100);

        list($width, $height) = getimagesize($tmpImage);

        $newWidth = $width;
        $newHeight = $height;
        $new = $this->source;

        if ($width > $maxWidth || $height > $maxHeight)
        {
            $proportions = $width / $height;
            	
            if ($width > $height)
            {
                $newWidth = $maxWidth;
                $newHeight = round($maxWidth / $proportions);
            }
            else
            {
                $newHeight = $maxHeight;
                $newWidth = round($maxHeight * $proportions);
            }
            	
            $new = imagecreatetruecolor($newWidth, $newHeight);
            $white = imagecolorallocate($new,  255, 255, 255);
            imagefilledrectangle($new, 0, 0, $newWidth, $newHeight, $white);
            imagecopyresampled($new, $this->source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        }
        	
        $path = $this->getSavePath($output);

        imagejpeg($new, $path . $name, 100);
        imagedestroy($new);
    }

    private function getSavePath($output)
    {
        $user = SessionUser::getInstance()->getUser();
        $path = PATH_PHOTOS . $user->getId() . $output;
        $file = new File($path);
        if (!$file->exists())
        {
            $file->mkdir();
        }
        return $file->getPath();
    }
}

?>