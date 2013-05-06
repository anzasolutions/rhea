<?php

namespace pl\anzasolutions\github\util;

class BranchUtil
{
    public static function getCurrent($path = '.git/HEAD')
    {
        $content = file_get_contents($path);
        $lastSlashPosition = strrchr($content, '/');
        return substr($lastSlashPosition, 1);
    }
}

?>