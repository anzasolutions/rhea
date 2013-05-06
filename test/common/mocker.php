<?php

namespace common;

/**
 * Mocks elements of tested object.
 * @author anza
 * @since 13-10-2012
 */
class Mocker
{
    private $object;
    private $testCase;
    
    public function __construct($object)
    {
        $this->object = $object;
    }
    
    public function mock($field, $stub)
    {
        $class = new \ReflectionClass($this->object);
        $prop = $class->getProperty($field);
        $prop->setAccessible(true);
        $prop->setValue($this->object, $stub);
    }
    
    public function mocks(array $mocks)
    {
        $class = new \ReflectionClass($this->object);
        foreach ($mocks as $field => $stub)
        {
            $prop = $class->getProperty($field);
            $prop->setAccessible(true);
            $prop->setValue($this->object, $stub);
        }
    }
    
    public function getNoConstructorMock($className)
    {
        return $this->testCase->getMockBuilder($className)
                              ->disableOriginalConstructor()
                              ->getMock();
    }
    
    public function setTestCase(\PHPUnit_Framework_TestCase $testCase)
    {
        $this->testCase = $testCase;
    }
    
    // TODO: add method that will add a list of fields with mocks to be
    // mocked at once, because creating \ReflectionClass for each mock isn't efficient
    // when say 10 mocks is created for a test
}

?>