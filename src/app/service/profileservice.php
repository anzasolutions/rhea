<?php

namespace app\service;

use core\db\exception\NoResultException;
use core\service\AbstractService;
use core\service\ServiceException;

class ProfileService extends AbstractService
{
    /**
     * Perform delete operation on User.
     * @param string $user
     */
    public function delete(User $user)
    {
        return $this->dao->user->delete($user);
    }

    // TODO: to be completed
    private function updateUserPassword(User $user)
    {
        if ($user != null)
        {
            // generate new password as random MD5 value
             
            // update user password with newly generated one
            $user->setPassword();
            $this->dao->user->save($user);
        }
    }

    public function getUser($username)
    {
        try
        {
            return $this->dao->user->findByUsername($username);
        }
        catch (NoResultException $e)
        {
            throw new ServiceException();
        }
    }
}

?>