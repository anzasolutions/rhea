<?php

namespace app\service\video\service;

use app\service\video\exception\VideoException;

class DailyMotionVS extends AbstractVS
{
    const API = 'https://api.dailymotion.com/video/';
    const PARAMS = '?fields=title,thumbnail_url,duration,thumbnail_url,thumbnail_medium_url,thumbnail_large_url';

    protected function parse()
    {
        $pattern = '/dailymotion\.com\/video\/([a-z0-9]{1,6})/';
        preg_match($pattern, $this->url, $matches);
        $this->id = $matches[1];
        $this->xml = self::API . $this->id . self::PARAMS;
    }

    protected function verify()
    {
        $headers = get_headers($this->xml);
        if (!strpos($headers[0], '200'))
        {
            throw new VideoException();
        }
    }

    protected function extract()
    {
        $this->title = $this->feed->title;
        $this->duration = $this->feed->duration;
        $this->thumbnail = $this->feed->thumbnail_medium_url;
    }

    protected function load()
    {
        $this->feed = json_decode($this->content);
    }
}

?>