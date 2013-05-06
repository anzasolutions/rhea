<?php

namespace app\controller;

use core\controller\Controller;
use core\controller\ControllerFactory;
use core\db\exception\IncorrectTypeException;
use core\service\ServiceException;
use core\system\container\ImageRequestFile;

/**
 * @Session
 */
class PhotoController extends Controller
{
    /**
     * @Invocable
     */
    protected function index()
    {
        $this->setAction('photos');
    }

    /**
     * @Invocable
     */
    protected function photos()
    {
        $this->getPhotosRange();
        $this->photoPageNumbers = $this->service->photo->getPhotoPageNumbers();
    }

    private function getPhotosRange()
    {
        try
        {
            $this->photos = $this->service->photo->getPhotosRange($this->url->getParameter(0));
        }
        catch (ServiceException $e)
        {
            // TODO: instead of displaying error return to page 1
            
            // FIXME: no such text bundle exists
            $this->error = $this->bundle->getText('photo.message.error.no.photos');
        }
    }

    /**
     * @Invocable
     */
    protected function user()
    {
        $userId = $this->url->getParameter(0);
        if ($userId == null)
        {
            $this->redirectToError();
        }
        $this->getLatestUserPhotos($userId);
    }

    private function getLatestUserPhotos($username)
    {
        try
        {
            $this->photos = $this->service->photo->getLatestUserPhotos($username, 18);
        }
        catch (ServiceException $e)
        {
            $this->error = $this->bundle->getText('photo.message.error.user.has.no.photos');
        }
    }

    /**
     * @Invocable
     * @Form = "newphoto"
     */
    protected function add($form)
    {
        try
        {
            $file = $this->request->getFile('file');
            $image = new ImageRequestFile($file);
            
            $type = $image->getType();
            $tmpName = $image->getTmpName();
            
            $this->service->photo->add($type, $tmpName);
            $this->redirectTo('photo');
        }
        catch (IncorrectTypeException $e)
        {
            $this->error = $this->bundle->getText('form.validation.file.not.image');
        }
    }

    /**
     * @Invocable
     */
    protected function show()
    {
        try
        {
            if (!$this->url->hasParameters())
            {
                $this->redirectToError();
            }
            $photoId = intval($this->url->getParameter(0));
            $this->photo = $this->service->photo->getPhoto($photoId);
            $this->photoOlder = $this->service->photo->getPhotoOlder($photoId);
        }
        catch (ServiceException $e)
        {
            //			$this->error = $this->bundle->getText('photo.message.error.user.has.no.photos');
        }
        $factory = new ControllerFactory();
        $factory->create('comment')->getComments();
    }
}

?>