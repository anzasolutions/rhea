<?php

namespace app\service\video\service;

use app\service\video\exception\VideoException;

class YouTubeVS extends AbstractVS
{
    const API = 'http://gdata.youtube.com/feeds/api/videos/';

    protected function parse()
    {
        parse_str(parse_url($this->url, PHP_URL_QUERY));
        $this->id = $v;
        $this->xml = self::API . $this->id;
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
        $media = $this->feed->children('http://search.yahoo.com/mrss/');

        $this->title = $media->group->title;

        $yt = $media->children('http://gdata.youtube.com/schemas/2007');
        $attrs = $yt->duration->attributes();
        $this->duration = intval($attrs['seconds']);

        $attrs = $media->group->thumbnail[1]->attributes();
        $this->thumbnail = $attrs['url'];
    }
}

?>