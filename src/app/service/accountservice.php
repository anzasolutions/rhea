<?php

namespace app\service;

use core\constant\Separator;
use core\db\exception\DuplicateException;
use core\db\exception\NoResultException;
use core\service\AbstractService;
use core\service\ServiceException;
use core\system\URL;
use core\util\HashGenerator;
use core\util\Mailer;
use core\util\PasswordGenerator;
use core\util\TextBundle;

use app\constant\Roles;
use app\model\Role;
use app\model\User;

class AccountService extends AbstractService
{
    /**
     * Login validated user.
     * @return User $user
     */
    public function login($email, $password)
    {
        try
        {
            $user = $this->dao->user->findByEmailAndPassword($email, $password);
            $this->updateUserActivity($user);
            return $user;
        }
        catch (NoResultException $e)
        {
            throw new ServiceException();
        }
    }

    /**
     * Update User with latest activity date and visit number.
     * @param User $user
     */
    private function updateUserActivity(User $user)
    {
        $visit = intval($user->getVisit());
        $user->setVisit(++$visit);
        $user->setLastActive(null);
        $this->dao->user->save($user);
    }

    /**
     * Change and send new password to email found.
     */
    public function recover($email)
    {
        try
        {
            $user = $this->dao->user->findByEmail($email);
            $newPassword = $this->updateUserPassword($user);
            $this->sendPassword($user, $newPassword);
        }
        catch (NoResultException $e)
        {
            throw new ServiceException();
        }
    }

    /**
     * Generate and update User with new password.
     * @param User $user
     * @return string
     */
    private function updateUserPassword(User $user)
    {
        $newPassword = PasswordGenerator::generate();
        $newPasswordHash = HashGenerator::generate(HashGenerator::MD5, $newPassword);
        $user->setPassword($newPasswordHash);
        $this->dao->user->save($user);
        return $newPassword;
    }

    /**
     * New password is send to email of selected User.
     * @param User $user
     * @param string $password
     */
    private function sendPassword(User $user, $password)
    {
        $subject = TextBundle::getInstance()->getText('recover.mail.subject');
        $message = $password;
        Mailer::send($user->getEmail(), $subject, $message);
    }

    /**
     * Activate existing User.
     * @param string $activeHash
     */
    public function activate($activeHash)
    {
        try
        {
            $user = $this->dao->user->findByActivation($activeHash);
            $user->setActive(true);
            $this->dao->user->save($user);
        }
        catch (NoResultException $e)
        {
            throw new ServiceException();
        }
    }

    /**
     * Register new User.
     */
    public function register($username, $email, $password)
    {
        try
        {
            $user = $this->createUser($username, $email, $password);
            $this->dao->user->save($user);
            $this->sendActivationLink($user);
        }
        catch (DuplicateException $e)
        {
            throw new ServiceException($e->getField());
        }
    }

    /**
     * Making new User to register.
     * @return User
     */
    private function createUser($username, $email, $password)
    {
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setLatestIP(null);
        $user->setLastActive(null);
        $user->setActivation($this->makeActivationHash($user));

        $role = new Role();
        $role->setId(Roles::USER);

        $user->setRole($role);
        return $user;
    }

    /**
     * Making User activation hash.
     * @param User $user
     * @return string
     */
    private function makeActivationHash(User $user)
    {
        return HashGenerator::generate(HashGenerator::MD5, $user->getUsername() . $user->getEmail() . $user->getPassword());
    }

    /**
     * Sends email with activation link.
     * @param User $user
     */
    private function sendActivationLink(User $user)
    {
        $subject = TextBundle::getInstance()->getText('register.mail.subject');
        $message = URL::getInstance()->build('account', 'activate') . Separator::SLASH . $user->getActivation();
        Mailer::send($user->getEmail(), $subject, $message);
    }
}

?>