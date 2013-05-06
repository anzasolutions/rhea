<?php

namespace app\model;

use core\util\DateFormat;

/**
 * @Entity
 */
class User
{
    private $id;
    private $username;
    private $password;
    private $email;
    private $online;
    private $avatar;
    private $active;
    private $visit;
    private $lastActive;
    private $latestIP;
    private $activation;

    /**
     * @Role
     * @Fetch = "eager"
     */
    private $role;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function isOnline()
    {
        return $this->online;
    }

    public function setOnline($online)
    {
        $this->online = (bool) $online;
    }

    public function hasAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = (bool) $active;
    }

    public function getVisit()
    {
        return $this->visit;
    }

    public function setVisit($visit)
    {
        $this->visit = $visit;
    }

    public function getLastActive()
    {
        if ($this->lastActive == null)
        {
            return DateFormat::getNow();
        }
        return $this->lastActive;
    }

    public function setLastActive($lastActive)
    {
        if ($lastActive == null)
        {
            $lastActive = DateFormat::getNow();
        }
        $this->lastActive = $lastActive;
    }

    public function getLatestIP()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $ipDivided = explode(".", $ip);
        if (count($ipDivided) < 4)
        {
            return '127.0.0.1';
        }
        return $ip;
    }

    public function setLatestIP($latestIP)
    {
        $this->latestIP = $_SERVER['REMOTE_ADDR'];
    }

    public function getActivation()
    {
        return $this->activation;
    }

    public function setActivation($activation)
    {
        $this->activation = $activation;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }
}

?>