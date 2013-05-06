<?php

namespace core\db\mysql;

use core\db\common\AbstractQuery;

/**
 * Object representation of MySQL query.
 */
class MySQLQuery extends AbstractQuery
{
    public function __construct(MySQLDriver $driver)
    {
        parent::__construct($driver);
    }

    public function limit($position, $limit)
    {
        $this->query .= ' LIMIT '.$position.','.$limit;
        return $this;
    }
}

?>