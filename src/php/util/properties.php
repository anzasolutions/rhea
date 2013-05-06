<?php

namespace php\util;

use php\io\FileNotFoundException;

class Properties
{
    public function load($file)
    {
        $lines = $this->read($file);
        return $this->convert($lines);
    }
    
    private function read($file)
    {
        if (!file_exists($file))
        {
            throw new FileNotFoundException('Cannot read file: ' . $file);
        }
        return file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }
    
    private function convert($lines)
    {
        $properties = array();
        foreach ($lines as $line)
        {
            $keyValue = explode('=', $line);
            $properties[trim($keyValue[0])] = trim($keyValue[1]);
        }
        return $properties;
    }
}

?>