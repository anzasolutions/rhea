<?php

namespace app\service;

use core\db\exception\NoResultException;
use core\service\AbstractService;
use core\service\ServiceException;

class FriendsService extends AbstractService
{
    public function getUsers($limit = 5)
    {
        return $this->dao->user->findByLatestActive($limit);
    }

    public function getUsersByName($name)
    {
        try
        {
            return $this->dao->user->findByName($name);
        }
        catch (NoResultException $e)
        {
            throw new ServiceException();
        }
    }
}

?>