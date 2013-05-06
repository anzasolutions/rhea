<?php

namespace core\db\mysql;

use core\db\Query;
use core\db\Transaction;
use core\db\common\AbstractDriver;
use core\db\constant\CommitMode;
use core\db\exception\ConnectionException;
use core\db\exception\DuplicateException;
use core\db\exception\QueryException;

/**
 * Encapsulate PHP MySQLi extension.
 * Operate only on MySQL type database.
 */
class MySQLDriver extends AbstractDriver
{
    public static $count = 0;

    public function connect()
    {
        try
        {
            $this->connection = mysqli_init();
            $this->connection->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
            $this->connection->real_connect($this->config->hostname, $this->config->username, $this->config->password, $this->config->database);
            if ($this->connection->connect_error)
            {
                throw new ConnectionException('Cannot connect to database!');
            }
        }
        catch (ConnectionException $e)
        {
            $e->getTraceAsString();
        }
    }

    public function createQuery()
    {
        return new MySQLQuery($this);
    }

    public function execute(Query $query)
    {
        if (DEBUG_SQL)
        {
            $this->debug($query);
        }
         
        $result = $this->connection->query($query);
        $this->result = new MySQLResult($result);
        
        $error = $this->connection->error;
        $errorno = $this->connection->errno;
        if ($error != null)
        {
            if ($errorno == 1062)
            {
                throw new DuplicateException($error);
            }
            throw new QueryException($error);
        }
    }

    private function debug($query)
    {
        ++self::$count;
        echo '<br/>#' . self::$count . '. ' . $query . '<br/>' . "\n";
    }

    public function setCommitMode(CommitMode $mode)
    {
        $this->connection->autocommit($mode);
    }

    public function commit()
    {
        $this->connection->commit();
    }

    public function rollback()
    {
        $this->connection->rollback();
    }

    public function beginTransaction()
    {
        return new Transaction($this);
    }

    public function escape($string)
    {
        return $this->connection->real_escape_string($string);
    }

    public function disconnect()
    {
        $thread_id = $this->connection->thread_id;
        $this->connection->kill($thread_id);
        $this->connection->close();
    }
}

?>