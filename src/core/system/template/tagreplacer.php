<?php

namespace core\system\template;

use core\util\TextBundle;

class TagReplacer
{
    private $content;
    private $values;

    public function __construct($content, $values)
    {
        $this->content = $content;
        $this->values = $values;
    }

    public function replace()
    {
        $this->assignVariables();
        $this->assignConstants();
        $this->assignBundles();
        $this->assignForeach();
        $this->clear();
        return $this->content;
    }

    private function assignVariables()
    {
        if ($this->values != null)
        {
            foreach ($this->values as $key => $value)
            {
                if (is_array($value))
                {
                    if (sizeof($value) > 0)
                    {
                        // does array contain an array?
                        // if yes, skip as it's foreach data structure
                        if (is_array($value[0]))
                        {
                            continue;
                        }
                        $value = implode('', $value);
                    }
                }
                $this->content = $this->simpleReplace($key, $value);
            }
        }
    }

    private function simpleReplace($key, $value)
    {
        return str_replace('#{'.$key.'}', $value, $this->content);
    }

    private function assignConstants()
    {
        foreach (get_defined_constants() as $key => $value)
        {
            $this->content = $this->simpleReplace($key, $value);
        }
    }

    private function assignBundles()
    {
        if (preg_match_all('/#{msg:([a-z0-9\.]*)}/', $this->content, $matches))
        {
            $patterns = $matches[0];
            $values = $matches[1];

            foreach ($patterns as $key => $pattern)
            {
                $bundle = TextBundle::getInstance()->getText($values[$key]);
                $this->content = str_replace($pattern, $bundle, $this->content);
            }
        }
    }

    // for some reason only one foreach is possible per template
    private function assignForeach()
    {
        // find all 'for' tag initials
        if (preg_match_all('/#{for:(.*)}/', $this->content, $matches))
        {
            $patterns = $matches[0];
            $values = $matches[1];

            // iterate over 'for' tags found
            foreach ($patterns as $key1 => $pattern)
            {
                // if 'for' name equals key in values go further
                if (array_key_exists($values[$key1], $this->values))
                {
                    // get full content of particular 'for' tag
                    if (preg_match_all('/'.$pattern.'(.*)#{for}/s', $this->content, $matches2))
                    {
                        $replacement = '';
                        foreach ($matches2[0] as $tagToReplace2)
                        {
                            $fragment = $matches2[1][$key1];
                            foreach ($this->values[$values[$key1]] as $value)
                            {
                                $f = $fragment;
                                foreach ($value as $key2 => $val)
                                {
                                    $f = str_replace('#{'.$key2.'}', $val, $f);
                                }
                                $replacement .= $f;
                            }
                        }
                        // replace full content of particular 'for' tag
                        $this->content = str_replace($tagToReplace2, $replacement, $this->content);
                    }
                }
            }
        }
    }

    private function clear()
    {
        $this->content = preg_replace('/#{(.*)}/', '', $this->content);
    }
}

?>