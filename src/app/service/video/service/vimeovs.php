<?php

namespace app\service\video\service;

use app\service\video\exception\VideoException;

class VimeoVS extends AbstractVS
{
    const API = 'http://vimeo.com/api/v2/video/';
    const FORMAT = '.xml';

    protected function parse()
    {
        $pattern = '/vimeo\.com\/([0-9]{1,10})/';
        preg_match($pattern, $this->url, $matches);
        if ($matches[1] == null)
        {
            throw new VideoException();
        }
        $this->id = $matches[1];
        $this->xml = self::API . $this->id . self::FORMAT;
    }

    protected function verify()
    {
        foreach ($this->feed->children() as $video)
        {
            if ($video->id == '')
            {
                throw new VideoException();
            }
        }
    }

    protected function extract()
    {
        foreach ($this->feed->children() as $video)
        {
            $this->title = $video->title;
            $this->duration = $video->duration;
            $this->thumbnail = $video->thumbnail_medium;
        }
    }
}

?>