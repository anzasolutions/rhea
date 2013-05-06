<?php

namespace core\dao;

interface DAO
{
    public function save($entity);

    public function delete($entity);
    
    public function findById($id);
    
    public function findAll();
    
    public function count();
}

?>