<?php

namespace php\util;

use php\io\FileNotFoundException;

class PropertiesTest extends \PHPUnit_Framework_TestCase
{
    private $properties;
    
    public function setUp()
    {
        $this->properties = new Properties();
    }
    
    private function getFile($filename)
    {
        return dirname(__FILE__) . '/../../resources/'.$filename.'.properties';
    }

    /**
     * @test
     */
    public function fileIsReadAndConvertedToPropertiesProperly()
    {
        $expected = array('test.value.number.one' => '!Some value is given {0}\\\'',
                          'test.value.number.two' => 'Some {0} value is {1} given',
                          'test.value.number.three' => 'Some value is given',
                          'test.value.number.four' => 'Some value is given',
                          'test.value.number.five' => 'Some value is given!');
        
        $file = $this->getFile('test');
        $actual = $this->properties->load($file);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function emptyFileIsReadAndConvertedToEmptyProperties()
    {
        $expected = array();
        
        $file = $this->getFile('emptyFile');
        $actual = $this->properties->load($file);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     * @expectedException php\io\FileNotFoundException
     */
    public function attemptToReadNonExistingPropertiesFileThrowsAnException()
    {
        $this->properties->load('');
    }
}

?>