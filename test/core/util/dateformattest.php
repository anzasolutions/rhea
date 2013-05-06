<?php

namespace core\util;

class DateFormatTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->date = '2012/10/12';
        $this->format = 'Y/m/d H-i-s';
        $this->expected = '2012-10-12 00:00:00';
    }

    /**
     * @test
     */
    public function currentDateTimeInDefaultFormat()
    {
        $actual = DateFormat::convert($this->date);

        $this->assertEquals($this->expected, $actual);
    }

    /**
     * @test
     */
    public function dateTimeInCustomFormat()
    {
        $expected = '2012/10/12 00-00-00';

        $actual = DateFormat::convert($this->date, $this->format);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function whenDateIsNullConversionIsSuccessfulWithCurrentDate()
    {
        $dt = new \DateTime(null);
        $expected = $dt->format($this->format);

        $actual = DateFormat::convert(null, $this->format);

        $this->assertEquals($expected, $actual);
    }
}

?>