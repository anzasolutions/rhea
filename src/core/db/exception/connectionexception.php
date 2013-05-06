<?php

namespace core\db\exception;

/**
 * Thrown when database connection problem occurs.
 * @author anza
 * @version 18-06-2011
 */
class ConnectionException extends DBException
{
    public function getName()
    {
        $name = get_class($this);
        return $name;
    }
}

?>