<?php

namespace core\system\container;

use php\util\AbstractContainer;

/**
 * Wrapper for $_GET, $_POST, $_FILES and $_REQUEST.
 * Single request is handled based on its type.
 * @author anza
 * @since 03-10-2010
 */
class Request extends AbstractContainer
{
    private static $instance;

    private $files;
    private $size;

    private function __construct()
    {
        $this->detectMethod();
        $this->setSize();
    }

    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function detectMethod()
    {
        switch ($_SERVER['REQUEST_METHOD'])
        {
            case 'POST':
                $this->values = $_POST;
                $this->files = $_FILES;
                break;
            case 'GET':
                $this->values = $_GET;
                break;
            default:
                $this->values = $_REQUEST;
        }
    }
    
    private function setSize()
    {
        if (isset($_SERVER['CONTENT_LENGTH']))
        {
            $this->size = $_SERVER['CONTENT_LENGTH'];
        }
    }
    
    public function checkSize()
    {
        $maxSize = $this->getBytes(ini_get('post_max_size'));
        if ($this->size > $maxSize)
        {
            $sizeMb = number_format($this->size / 1048576);
            throw new \LengthException($sizeMb);
        }
    }
    
    private function getBytes($val)
    {
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        switch ($last)
        {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
        return $val;
    }

    public function getFile($name)
    {
        return new RequestFile($this->files[$name]);
    }
}

?>