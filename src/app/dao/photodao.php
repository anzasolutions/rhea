<?php

namespace app\dao;

use core\dao\AbstractDAO;

class PhotoDAO extends AbstractDAO
{
    public function findLatestForUser($username, $limit)
    {
        $query = $this->simpleFrom();
        $query->join('user', $this->type);
        $query->where('user.username', $username);
        $query->orderBy('added');
        $query->desc();
        $query->limit(0, $limit);
        return $this->result($query);
    }

    public function findRange($position, $limit)
    {
        $query = $this->simpleFrom();
        $query->join('user', $this->type);
        $query->orderBy('added');
        $query->desc();
        $query->limit($position, $limit);
        return $this->result($query);
    }

    public function findPreviousForUserById($id)
    {
        $subQuery = $this->driver->createQuery();
        $subQuery->select('userid');
        $subQuery->from($this->type);
        $subQuery->where('id', $id);
         
        $query = $this->simpleFrom();
        $query->where($this->type . '.id', $id, $query->less());
        $query->add('userid', $subQuery, $query->in());
        $query->orderBy($this->type . '.id');
        $query->desc();
        $query->limit(0, 1);
        return $this->singleResult($query);
    }
}

?>