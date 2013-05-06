<?php

namespace core\service;

use common\Mocker;

/**
 * @author anza
 * @since 14-10-2012
 */
class ServicePoolTest extends \PHPUnit_Framework_TestCase
{
    private $object;
    private $mocker;
    
    public function setUp()
    {
        $this->object = ServicePool::getInstance();
        $this->mocker = new Mocker($this->object);
    }
    
    /**
     * @test
     */
    public function serviceAlreadyInPoolIsProperlyRetrieved()
    {
        $expected = new \stdClass();
        
        $stub = $this->getMock('php\util\Container');
        
        $stub->expects($this->once())
             ->method('hasKey')
             ->with($this->equalTo('someService'))
             ->will($this->returnValue(true));
        
        $stub->expects($this->once())
             ->method('__get')
             ->with($this->equalTo('someService'))
             ->will($this->returnValue($expected));
             
        $this->mocker->mock('pool', $stub);
        
        $actual = $this->object->someService;
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @test
     */
    public function serviceNotYetInPoolIsProperlyRetrieved()
    {
        $expected = $this->getMock('app\service\someService');
        
        $stub = $this->getMock('php\util\Container');
        
        $stub->expects($this->once())
             ->method('hasKey')
             ->with($this->equalTo('some'))
             ->will($this->returnValue(false));
             
        $stub->expects($this->once())
             ->method('__set')
             ->with($this->equalTo('some'), $this->isInstanceOf('app\service\someService'));
             
        $stub->expects($this->once())
             ->method('__get')
             ->with($this->equalTo('some'))
             ->will($this->returnValue($expected));
        
        $this->mocker->mock('pool', $stub);
        
        $actual = $this->object->some;
        
        $this->assertEquals($expected, $actual);
    }
}

?>