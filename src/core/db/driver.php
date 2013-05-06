<?php

namespace core\db;

use core\db\constant\CommitMode;

interface Driver
{
    /**
     * Explicitly called connects to a database.
     */
    public function connect();

    /**
     * Construct convinient query.
     * @return object Query
     */
    public function createQuery();

    /**
     * Executes SQL query against database.
     * @param string $sql SQL query to be executed against database.
     */
    public function execute(Query $query);

    /**
     * Turn on/off autocommit mode.
     * Used for handling transactions.
     */
    public function setCommitMode(CommitMode $mode);
    
    /**
     * Confirm execution of query in transaction.
     */
    public function commit();

    /**
     * Revert queries in transaction.
     */
    public function rollback();

    /**
     * Escapes non-ASCII characters before input to database.
     * String is immunized and more secure for further use.
     * @param string $string String to be escaped and used within SQL query.
     */
    public function escape($string);

    /**
     * Close database connection.
     */
    public function disconnect();

    /**
     * Return obtained query result.
     */
    public function getResult();

    /**
     * Initialize transaction.
     */
    public function beginTransaction();
}

?>