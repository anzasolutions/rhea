<?php

namespace core\db\mysql;

use core\db\common\AbstractResult;

/**
 * Wrapper of \MySQLi_Result class.
 */
class MySQLResult extends AbstractResult
{
    public function fetch($method = null)
    {
        switch ($method)
        {
            case 'array':
                return $this->result->fetch_array();
            default:
                return $this->result->fetch_object();
        }
    }

    public function getSize()
    {
        if ($this->result instanceof \MySQLi_Result)
        {
            return $this->result->num_rows;
        }
    }

    public function flush()
    {
        $this->result = null;
    }
}

?>