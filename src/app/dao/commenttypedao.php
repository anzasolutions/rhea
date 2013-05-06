<?php

namespace app\dao;

use core\dao\AbstractDAO;

class CommentTypeDAO extends AbstractDAO
{
    public function findByName($name)
    {
        $query = $this->simpleFrom();
        $query->joinAll($this->type);
        $query->where('name', $name);
        return $this->singleResult($query);
    }
}

?>