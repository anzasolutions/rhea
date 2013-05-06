<?php

namespace app\dao;

use core\dao\AbstractDAO;

class ProductDAO extends AbstractDAO
{
    public function findLatest($limit)
    {
        $query = $this->simpleFrom();
        $query->join('productCategory', $this->type);
        $query->orderBy($this->type.'.id');
        $query->desc();
        $query->limit(0, $limit);
        return $this->result($query);
    }

    public function findByCategoryId($id, $limit)
    {
        $query = $this->simpleFrom();
        $query->join('productCategory', $this->type);
        $query->where('productCategory.id', $id);
        $query->orderBy($this->type.'.id');
        $query->desc();
        $query->limit(0, $limit);
        return $this->result($query);
    }
}

?>