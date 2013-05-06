<?php

namespace app\dao;

use core\dao\AbstractDAO;

class VideoDAO extends AbstractDAO
{
    public function findRange($position, $limit)
    {
        $query = $this->simpleFrom();
        $query->join('videotype', $this->type);
        $query->orderBy('added');
        $query->desc();
        $query->limit($position, $limit);
        return $this->result($query);
    }

    public function findUserVideosRange($username, $position, $limit)
    {
        $query = $this->simpleFrom();
        $query->join('user', $this->type);
        $query->join('role', 'user');
        $query->where('user.username', $username);
        $query->orderBy('added');
        $query->desc();
        $query->limit($position, $limit);
        return $this->result($query);
    }

    public function countByUserId($username)
    {
        $query = $this->simpleCount();
        $query->join('user', $this->type, false);
        $query->where('user.username', $username);
        return $this->count($query);
    }

    public function findLikeTitle($title, $position, $limit)
    {
        $query = $this->simpleFrom();
        $query->where('title', '%'.$title.'%', $query->like());
        $query->orderBy('added');
        $query->desc();
        $query->limit($position, $limit);
        return $this->result($query);
    }
}

?>