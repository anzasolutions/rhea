<?php

namespace php\io;

class FileReader
{
    private $file;
    
    public function __construct(File $file)
    {
        $this->file = $file;
    }
    
    public function __toString()
    {
        return file_get_contents($this->file->getPath());
    }
}

?>