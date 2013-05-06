<?php

namespace app\service;

use core\constant\FileSuffix;
use core\db\exception\NoResultException;
use core\service\AbstractService;
use core\service\ServiceException;
use core\system\session\SessionUser;
use core\util\RandomString;

use app\model\Photo;
use app\model\User;
use app\util\PhotoTransformer;

class PhotoService extends AbstractService
{
    private static $wallSize = 24;
    
    public function save(Photo $photo)
    {
        return $this->dao->photo->save($photo);
    }

    // TODO: the body of the method is a perfect candidate for a method transaction introduction
    //       storeFile and save photo should be synchronized, so either both success or none
    public function add($type, $tmpName)
    {
        $user = SessionUser::getInstance()->getUser();
        $name = RandomString::generate();
        $this->storeFile($type, $tmpName, $name);
        $photo = $this->createPhoto($user, $name);
        $this->dao->photo->save($photo);
    }

    private function createPhoto(User $user, $name)
    {
        $photo = new Photo();
        $photo->setFile($name.FileSuffix::JPG);
        $photo->setUser($user);
        $photo->setAdded(null);
        return $photo;
    }

    private function storeFile($type, $tmpName, $name)
    {
        $pt = new PhotoTransformer($type, $tmpName, $name);
        $pt->resize(131, 131, '/thumbs/');
        $pt->resize(620, 620, '/big/');
    }

    public function getLatestUserPhotos($username, $limit = 5)
    {
        try
        {
            return $this->dao->photo->findLatestForUser($username, $limit);
        }
        catch (NoResultException $e)
        {
            throw new ServiceException();
        }
    }

    public function getPhoto($id)
    {
        try
        {
            return $this->dao->photo->findById($id);
        }
        catch (NoResultException $e)
        {
            throw new ServiceException();
        }
    }

    public function getPhotoOlder($id)
    {
        try
        {
            return $this->dao->photo->findPreviousForUserById($id);
        }
        catch (NoResultException $e)
        {
            throw new ServiceException();
        }
    }

    public function getPhotoPageNumbers()
    {
        $photosNo = $this->getPhotosCount();
        return ceil($photosNo / self::$wallSize);
    }

    private function getPhotosCount()
    {
        return $this->dao->photo->count();
    }

    public function getPhotosRange($start)
    {
        $span = self::$wallSize;
        $limit = self::$wallSize;
        $position = 0;

        if ($start != null)
        {
            $total = $start * $span;
            $position = $total - $span;
        }
        
        try
        {
            return $this->dao->photo->findRange($position, $limit);
        }
        catch (NoResultException $e)
        {
            throw new ServiceException();
        }
    }
}

?>