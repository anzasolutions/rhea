<?php

namespace app\util;

use core\system\URL;
use core\util\TextBundle;
use core\view\dom\Link;
use core\view\dom\Span;

/**
 * Handle pages index.
 * @author anza
 * @version 19-07-2011
 */
abstract class PageIndex
{
    const ZERO = 0;
    const ONE = 1;

    /**
     * Generate page index.
     * @param integer $numberOfPages to be generated
     * @param integer $pageParameter from URL
     * @return string
     */
    public static function makeIndex($numberOfPages, $pageParameter = 0)
    {
        $bundle = TextBundle::getInstance();
        $url = URL::getInstance();

        $currentPage = $url->getParameter($pageParameter);
        $pageIndex = '';
        $previous = $bundle->getText('navigation.previous');
        $next = $bundle->getText('navigation.next');

        if ($currentPage != null && $currentPage != self::ONE)
        {
            $link = new Link(substr_replace($url, $currentPage - 1, strrpos($url, '/') + 1), $previous);
            $pageIndex .= $link;
        }
        else
        {
            $span = new Span($previous);
            $pageIndex .= $span->addClass('inactive');
        }
        
        if ($currentPage == null)
        {
            $url .= '/0';
        }

        for ($i = self::ONE; $i <= intval($numberOfPages); $i++)
        {
            $link = new Link(substr_replace($url, $i, strrpos($url, '/') + 1), $i);
            if ($i == $currentPage || ($currentPage == null && $i == self::ONE))
            {
                $span = new Span($i);
                $link = $span->addClass('current-page');
            }
            $pageIndex .= $link;
        }

        if ($currentPage == null)
        {
            $currentPage = self::ONE;
        }
        
        if ($currentPage != $numberOfPages)
        {
            $link = new Link(substr_replace($url, $currentPage + 1, strrpos($url, '/') + 1), $next);
            $pageIndex .= $link;
        }
        else
        {
            $span = new Span($next);
            $pageIndex .= $span->addClass('inactive');
        }
        return $pageIndex;
    }
}

?>