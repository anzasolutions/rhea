<?php

namespace php\io;

class File
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function isFile()
    {
        return is_file($this->path);
    }

    public function isDirectory()
    {
        return is_dir($this->path);
    }

    public function mkdir()
    {
        mkdir($this->path, 0777, true);
    }

    public function exists()
    {
        return file_exists($this->path);
    }

    public function delete()
    {
        unlink($this->path);
    }

    public function getPath()
    {
        return $this->path;
    }
}

?>