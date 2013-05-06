<?php

namespace app\util;

use php\util\Container;

class RandomNumbers
{
    private $start;
    private $end;
    private $iterations;

    public function __construct($start, $end, $iterations)
    {
        $this->start = $start;
        $this->end = $end;
        $this->iterations = $iterations;
    }

    public function generate()
    {
        if ($this->iterations > $this->end)
        {
            $this->iterations = $this->end;
        }

        $numbers = new Container();
        for ($i = 0; $i < $this->iterations; $i++)
        {
            while ($numbers->hasValue($number = mt_rand($this->start, $this->end)))
            {
                continue;
            }
            $numbers->add($number);
        }
        return $numbers;
    }
}

?>