<?php

namespace core\util;

use common\Mocker;
use common\TestController;

class NavigatorTest extends \PHPUnit_Framework_TestCase
{
    private $object;
    private $mocker;
    
    public static function setUpBeforeClass()
    {
        define('URL_APP', 'http://localhost/rhea/');
    }
    
    public function setUp()
    {
        $this->object = new Navigator();
        $this->mocker = new Mocker($this->object);
    }
    
    /**
     * @test
     */
    public function whenStringIsProvidedRedirectionIsSuccessful()
    {
        $stub = $this->getMock('core\util\Header');
        
        $stub->expects($this->once())
             ->method('header')
             ->with($this->equalTo('http://localhost/rhea/test'));
        
        $this->mocker->mock('header', $stub);
        
        $this->object->redirectTo('test');
    }
    
    /**
     * @test
     */
    public function whenControllerObjectIsProvidedRedirectionIsSuccessful()
    {
        $stub = $this->getMock('core\util\Header');
        
        $stub->expects($this->once())
             ->method('header')
             ->with($this->equalTo('http://localhost/rhea/test'));
        
        $this->mocker->mock('header', $stub);
        
        $this->object->redirectTo(new TestController());
    }
    
    /**
     * @test
     */
    public function whenLinkIsProvidedRedirectionIsSuccessful()
    {
        $stub = $this->getMock('core\util\Header');
        
        $stub->expects($this->once())
             ->method('header')
             ->with($this->equalTo('http://localhost/rhea/test'));
        
        $this->mocker->mock('header', $stub);
        
        $this->object->redirectTo('http://localhost/rhea/test');
    }
    
    /**
     * @test
     */
    public function whenNothingIsProvidedRedirectionToMainUrlIsSuccessful()
    {
        $stub = $this->getMock('core\util\Header');
        
        $stub->expects($this->once())
             ->method('header')
             ->with($this->equalTo('http://localhost/rhea/'));
        
        $this->mocker->mock('header', $stub);
        
        $this->object->redirectTo();
    }
}

?>