<?php

namespace app\dao;

use core\dao\AbstractDAO;

class CommentDAO extends AbstractDAO
{
    public function findByCommentTypeNameAndTypeIdAndLimit($commentTypeName, $typeId, $position, $limit)
    {
        $query = $this->simpleFrom();
        $query->join('commenttype', $this->type);
        $query->join('user', $this->type);
        $query->where('commenttype.name', $commentTypeName);
        $query->add($this->type.'.typeid', $typeId);
        $query->orderBy('date');
        $query->desc();
        $query->limit($position, $limit);
        return $this->result($query);
    }

    public function countByCommentTypeNameAndTypeId($commentTypeName, $typeId)
    {
        $query = $this->simpleCount();
        $query->join('commenttype', $this->type, false);
        $query->where('commenttype.name', $commentTypeName);
        $query->add('typeid', $typeId);
        return $this->count($query);
    }
}

?>