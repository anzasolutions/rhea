<?php

namespace app\dao;

use core\dao\AbstractDAO;

class UserDAO extends AbstractDAO
{
    //TODO: make sure this is taken care of as this is a transaction handling
    //	public function findByUsernameAndPassword($username, $password)
    //	{
    //		$query = $this->driver->createQuery();
    //		$query->select()->from($this->type);
    //		$query->where('username', $username)->add('password', $password)->add('active', 1)->limit(1);
    //
    //		$user = $this->singleResult($query);
    //		$user->setLastActive(null);
    //
    //		$query2 = $this->driver->createQuery();
    //		$query2->update($user)->where(self::ID, $user->getId());
    //
    //		$query3 = $this->driver->createQuery();
    //		$query3->select()->from($this->type);
    //		$query3->where('username', $username)->add('password', $password)->add('active', 1)->limit(1);
    //
    //		$trans = $this->driver->beginTransaction();
    //		$trans->add($query2);
    //		$trans->add($query);
    //		$trans->add($query3);
    //		$trans->add($query);
    //		$trans->process();
    //	}

    public function findByEmailAndPassword($email, $password)
    {
        $query = $this->simpleFrom();
        $query->join('role', $this->type);
        $query->where('email', $email);
        $query->add('password', $password);
        $query->add('active', 1);
        return $this->singleResult($query);
    }

    public function findByActivation($activation)
    {
        $query = $this->simpleFrom();
        $query->join('role', $this->type);
        $query->where('activation', $activation);
        $query->add('active', 0);
        return $this->singleResult($query);
    }

    public function findByUsername($username)
    {
        $query = $this->simpleFrom();
        $query->where('username', $username);
        $query->add('active', 1);
        return $this->singleResult($query);
    }

    public function findByLatestActive($limit)
    {
        $query = $this->simpleFrom();
        $query->where('active', 1);
        $query->orderBy('lastActive');
        $query->desc();
        $query->limit(0, $limit);
        return $this->result($query);
    }

    public function findByName($username)
    {
        $query = $this->simpleFrom();
        $query->where('username', '%'.$username.'%', $query->like());
        $query->add('active', 1);
        $query->orderBy('lastActive');
        $query->desc();
        return $this->result($query);
    }

    public function findByEmail($email)
    {
        $query = $this->simpleFrom();
        $query->join('role', $this->type);
        $query->where('email', $email);
        $query->add('active', 1);
        return $this->singleResult($query);
    }
}

?>