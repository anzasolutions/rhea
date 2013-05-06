<?php

namespace core\annotation;

use php\util\Container;

use common\Mocker;

class AnnotationClassTest extends \PHPUnit_Framework_TestCase
{
    private $object;
    private $mocker;
    
    public function setUp()
    {
        $this->class = $this->getMockBuilder('ReflectionClass')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->method = $this->getMockBuilder('ReflectionMethod')
                             ->disableOriginalConstructor()
                             ->getMock();
        
        $this->property = $this->getMockBuilder('ReflectionProperty')
                               ->disableOriginalConstructor()
                               ->getMock();
                           
        $this->object = new AnnotationClass('stdClass');
        $this->mocker = new Mocker($this->object);
    }
    
    /**
     * @test
     */
    public function getValueOfAnnotationSuccessfully()
    {
        $expected = 'foo';
        $docComment = '/**
                        * @SomeAnnotation = "foo"
                        */';
        
        $this->class->expects($this->once())
                    ->method('getDocComment')
                    ->will($this->returnValue($docComment));
        
        $this->mocker->mock('object', $this->class);
             
        $actual = $this->object->getValueOf('SomeAnnotation');
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @test
     */
    public function getValuesOfAnnotationSuccessfully()
    {
        $expected = array('foo', 'bar');
        $docComment = '/**
      	                * @SomeAnnotation = "foo, bar"
      	                */';
        
        $this->class->expects($this->once())
                    ->method('getDocComment')
                    ->will($this->returnValue($docComment));
        
        $this->mocker->mock('object', $this->class);
        
        $actual = $this->object->getValuesOf('SomeAnnotation');
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @test
     */
    public function getValueMapOfAnnotationSuccessfully()
    {
        $expected = array('foo' => 'bar', 'bar' => 'foo');
        $docComment = '/**
        				* @SomeAnnotation = "foo=bar, bar=foo"
        				*/';
        
        $this->class->expects($this->once())
                    ->method('getDocComment')
                    ->will($this->returnValue($docComment));
        
        $this->mocker->mock('object', $this->class);
        
        $actual = $this->object->getValueMapOf('SomeAnnotation');
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @test
     */
    public function getExpectedAnnotations()
    {
        $expected = new Container(array('SomeAnnotation = "foo=bar, bar=foo"'));
        $docComment = '/**
        				* @SomeAnnotation = "foo=bar, bar=foo"
        				*/';
        
        $this->class->expects($this->once())
                    ->method('getDocComment')
                    ->will($this->returnValue($docComment));
        
        $this->mocker->mock('object', $this->class);
        
        $actual = $this->object->getAnnotations();
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @test
     */
    public function getPropertyGivesCorrectAnnotationProperty()
    {
        $expected = new AnnotationProperty($this->property);
    
        $this->class->expects($this->once())
                    ->method('getProperty')
                    ->will($this->returnValue($this->property));
    
        $this->mocker->mock('object', $this->class);
    
        $actual = $this->object->getProperty('value');
    
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @test
     */
    public function getPropertyWithAnnotationParameterGivesCorrectAnnotationProperty()
    {
        $docComment = '/**
                        * @SomeAnnotation = "foo=bar, bar=foo"
                        */';
        
        $expected = new AnnotationProperty($this->property);
    
        $this->class->expects($this->once())
                    ->method('getProperty')
                    ->will($this->returnValue($this->property));
    
        $this->property->expects($this->once())
                       ->method('getDocComment')
                       ->will($this->returnValue($docComment));
    
        $this->mocker->mock('object', $this->class);
    
        $actual = $this->object->getProperty('value', 'SomeAnnotation');
    
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @test
     */
    public function getPropertyWithAnnotationParameterForNonAnnotatedPropertyGivesAnEmptyResult()
    {
        $this->class->expects($this->once())
                    ->method('getProperty')
                    ->will($this->returnValue($this->property));
    
        $this->mocker->mock('object', $this->class);
    
        $actual = $this->object->getProperty('value', 'NotExistingAnnotation');
    
        $this->assertEmpty($actual);
    }
    
    /**
     * @test
     */
    public function getPropertiesGivesCorrectAnnotationProperties()
    {
        $expected = array(new AnnotationProperty($this->property), new AnnotationProperty($this->property));
    
        $this->class->expects($this->once())
                    ->method('getProperties')
                    ->will($this->returnValue(array($this->property, $this->property)));
    
        $this->mocker->mock('object', $this->class);
    
        $actual = $this->object->getProperties();
    
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @test
     */
    public function getPropertiesWithAnnotationParameterGivesCorrectAnnotationProperties()
    {
        $docComment = '/**
                        * @SomeAnnotation = "foo=bar, bar=foo"
                        */';
    
        $expected = array(new AnnotationProperty($this->property), new AnnotationProperty($this->property));
    
        $this->class->expects($this->once())
                    ->method('getProperties')
                    ->will($this->returnValue(array($this->property, $this->property)));
    
        $this->property->expects($this->at(0))
                       ->method('getDocComment')
                       ->will($this->returnValue($docComment));
    
        $this->property->expects($this->at(1))
                       ->method('getDocComment')
                       ->will($this->returnValue($docComment));
    
        $this->mocker->mock('object', $this->class);
    
        $actual = $this->object->getProperties('SomeAnnotation');
    
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @test
     */
    public function getPropertiesWithAnnotationParameterForNonAnnotatedPropertiesGivesAnEmptyArray()
    {
        $this->class->expects($this->once())
                    ->method('getProperties')
                    ->will($this->returnValue(array($this->property, $this->property)));
    
        $this->mocker->mock('object', $this->class);
    
        $actual = $this->object->getProperties('SomeAnnotation');
    
        $this->assertEmpty($actual);
    }
    
    /**
     * @test
     */
    public function getMethodGivesCorrectAnnotationMethod()
    {
        $expected = new AnnotationMethod($this->method);
    
        $this->class->expects($this->once())
                    ->method('getMethod')
                    ->will($this->returnValue($this->method));
    
        $this->mocker->mock('object', $this->class);
    
        $actual = $this->object->getMethod('someMethod');
    
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @test
     */
    public function getMethodWithAnnotationParameterGivesCorrectAnnotationMethod()
    {
        $docComment = '/**
                        * @SomeAnnotation = "foo=bar, bar=foo"
                        */';
        
        $expected = new AnnotationMethod($this->method);
    
        $this->class->expects($this->once())
                    ->method('getMethod')
                    ->will($this->returnValue($this->method));
    
        $this->method->expects($this->once())
                       ->method('getDocComment')
                       ->will($this->returnValue($docComment));
    
        $this->mocker->mock('object', $this->class);
    
        $actual = $this->object->getMethod('someMethod', 'SomeAnnotation');
    
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @test
     */
    public function getMethodWithAnnotationParameterForNonAnnotatedMethodGivesAnEmptyResult()
    {
        $this->class->expects($this->once())
                    ->method('getMethod')
                    ->will($this->returnValue($this->method));
    
        $this->mocker->mock('object', $this->class);
    
        $actual = $this->object->getMethod('someMethod', 'NotExistingAnnotation');
    
        $this->assertEmpty($actual);
    }
    
    /**
     * @test
     */
    public function getMethodsGivesCorrectAnnotationMethods()
    {
        $expected = array(new AnnotationMethod($this->method), new AnnotationMethod($this->method));
        
        $this->class->expects($this->once())
                    ->method('getMethods')
                    ->will($this->returnValue(array($this->method, $this->method)));
        
        $this->mocker->mock('object', $this->class);
        
        $actual = $this->object->getMethods();
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @test
     */
    public function getMethodsWithAnnotationParameterGivesCorrectAnnotationMethods()
    {
        $docComment = '/**
        				* @SomeAnnotation = "foo=bar, bar=foo"
        				*/';
        
        $expected = array(new AnnotationMethod($this->method));
        
        $this->class->expects($this->once())
                    ->method('getMethods')
                    ->will($this->returnValue(array($this->method, $this->method)));
        
        $this->method->expects($this->at(0))
                     ->method('getDocComment')
                     ->will($this->returnValue(''));
        
        $this->method->expects($this->at(1))
                     ->method('getDocComment')
                     ->will($this->returnValue($docComment));
        
        $this->mocker->mock('object', $this->class);
        
        $actual = $this->object->getMethods('SomeAnnotation');
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @test
     */
    public function getMethodsWithAnnotationParameterForNonAnnotatedMethodsGivesAnEmptyArray()
    {
        $this->class->expects($this->once())
                    ->method('getMethods')
                    ->will($this->returnValue(array($this->method, $this->method)));
        
        $this->mocker->mock('object', $this->class);
        
        $actual = $this->object->getMethods('SomeAnnotation');
        
        $this->assertEmpty($actual);
    }
}

?>