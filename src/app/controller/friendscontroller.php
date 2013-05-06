<?php

namespace app\controller;

use core\controller\Controller;
use core\service\ServiceException;

/**
 * @Session
 */
class FriendsController extends Controller
{
    /**
     * @Invocable
     * @Role = "admin"
     */
    protected function index()
    {
        $this->users = $this->service->friends->getUsers(70);
    }

    /**
     * @Invocable
     * @Form = "findfriend"
     */
    protected function find($form)
    {
        try
        {
            $name = $form->getName();
            $this->users = $this->service->friends->getUsersByName($name);
        }
        catch (ServiceException $e)
        {
            $this->error = $this->bundle->getText('friends.users.not.found', $name);
        }
    }
}

?>