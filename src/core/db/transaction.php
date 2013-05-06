<?php

namespace core\db;

use core\db\constant\CommitMode;
use core\db\exception\QueryException;

use php\util\Container;

class Transaction
{
    private $driver;
    private $queries;

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
        $this->queries = new Container();
    }

    /**
     * Add query to a pool of queries to be executed.
     * @param Query $query
     */
    public function add(Query $query)
    {
        $this->queries->add($query);
    }

    /**
     * Process all transaction queries.
     */
    public function process()
    {
        if ($this->queries->isEmpty())
        {
            return;
        }
        	
        $this->driver->setCommitMode(CommitMode::MANUAL);

        try
        {
            foreach ($this->queries as $query)
            {
                $this->driver->execute($query);
            }
            $this->driver->commit();
        }
        catch (QueryException $e)
        {
            $this->driver->rollback();
            $e->getTraceAsString();
        }

        $this->driver->setCommitMode(CommitMode::AUTO);
    }
}

?>