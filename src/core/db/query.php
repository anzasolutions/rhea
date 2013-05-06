<?php

namespace core\db;

interface Query
{
    /**
     * Represent SQL keyword SELECT.
     */
    public function select($columns = null);

    /**
     * Represent SQL query SELECT DISTINCT.
     */
    public function distinct($columns = null);

    /**
     * Represent SQL keyword FROM.
     */
    public function from($tables);

    /**
     * Represent SQL keyword WHERE.
     */
    public function where($column, $condition, $operator = null);

    /**
     * Represent SQL keyword AND.
     */
    public function add($column, $condition, $operator = null);

    /**
     * Represent SQL keyword AND for two columns.
     */
    public function addColumns($column1, $column2, $operator = null);

    /**
     * Represent SQL keyword OR.
     */
    public function other($column, $condition, $operator = null);

    /**
     * Represent SQL keyword ORDER BY.
     */
    public function orderBy($columns);

    /**
     * Represent SQL keyword DESC.
     */
    public function desc();

    /**
     * Represent SQL keyword ASC.
     */
    public function asc();

    /**
     * Represent SQL keyword UPDATE.
     */
    public function update($type);

    /**
     * Represent SQL keyword INSERT.
     */
    public function insert($type);

    /**
     * Represent SQL keyword DELETE.
     */
    public function delete();

    /**
     * Represent SQL keyword COUNT.
     */
    public function count();
    
    /**
     * Get aliases for given table.
     */
    public function buildAliases($table, $types = array());
    
    /**
     * Joins other tables of given table.
     */
    public function joinAll($table);
    
    /**
     * Return properly formatted LIKE string
     */
    public function like();
    
    /**
     * Return properly formatted IN string
     */
    public function in();
    
    /**
     * Return properly formatted < string
     */
    public function less();
    
    /**
     * Return properly formatted > string
     */
    public function more();
}

?>