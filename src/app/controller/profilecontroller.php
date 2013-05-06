<?php

namespace app\controller;

use core\service\ServiceException;

/**
 * @Session
 */
class ProfileController extends ItemController
{
    /**
     * @Invocable
     */
    protected function index()
    {
        $this->setAction('account');
    }

    /**
     * @Invocable
     */
    protected function account()
    {
        try
        {
            $this->profile = $this->service->profile->getUser($this->id);
        }
        catch (ServiceException $e)
        {
            $this->redirectToError();
        }
    }
}

?>