<?php

namespace php\util;

class AbstractContainerTest extends \PHPUnit_Framework_TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockForAbstractClass('php\util\AbstractContainer');
    }

    /**
     * @test
     */
    public function getValuesReturnsAnArrayWithKeyAndValue()
    {
        $expected = array('value');

        $this->stub->key = 'value';

        $actual = $this->stub->getValues();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function getValuesReturnsAnEmptyArray()
    {
        $actual = $this->stub->getValues();

        $this->assertEmpty($actual);
    }

    /**
     * @test
     */
    public function getIteratorReturnsArrayIteratorWithAnArrayWithKeyAndValue()
    {
        $expected = new \ArrayIterator(array('key' => 'value'));

        $this->stub->key = 'value';

        $actual = $this->stub->getIterator();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function hasKeyReturnsTrueWhenKeyExists()
    {
        $this->stub->key = 'value';

        $actual = $this->stub->hasKey('key');

        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function hasKeyReturnsFalseWhenKeyNotExists()
    {
        $actual = $this->stub->hasKey('key');

        $this->assertFalse($actual);
    }

    /**
     * @test
     */
    public function hasValueReturnsTrueWhenValueExists()
    {
        $this->stub->key = 'value';

        $actual = $this->stub->hasValue('value');

        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function hasValueReturnsFalseWhenValueNotExists()
    {
        $actual = $this->stub->hasValue('value');

        $this->assertFalse($actual);
    }

    /**
     * @test
     */
    public function elementIsProperlyRemovedFromContainer()
    {
        $this->stub->key = 'value';

        $actual = $this->stub->remove('key');

        $this->assertTrue($actual);
    }

    /**
     * @test
     * @expectedException php\util\NoSuchElementException
     */
    public function attemptToRemoveNonExistingElementThrowsAnException()
    {
        $this->stub->remove('notExistingKey');
    }

    /**
     * @test
     */
    public function elementIsPoppedResultingInAnEmptyContainer()
    {
        $expected = 'value';

        $this->stub->key = 'value';

        $actual = $this->stub->pop();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function attemptToPopNonExistingElementReturnsNull()
    {
        $actual = $this->stub->pop();

        $this->assertNull($actual);
    }

    /**
     * @test
     */
    public function valueIsReplacedProperly()
    {
        $this->stub->key = 'value';

        $actual = $this->stub->replace('key', 'newValue');

        $this->assertTrue($actual);
    }

    /**
     * @test
     * @expectedException php\util\NoSuchElementException
     */
    public function attemptToReplaceValueThrowsAnException()
    {
        $this->stub->replace('nonExistingKey', 'newValue');
    }

    /**
     * @test
     */
    public function valuesAreCleaned()
    {
        $this->stub->key = 'value';

        $actual = $this->stub->clear();

        $this->assertEmpty($actual);
    }

    /**
     * @test
     */
    public function sizeMatchesNumberOfAddedValues()
    {
        $expected = 1;
        
        $this->stub->key = 'value';

        $actual = $this->stub->size();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function arrayIsPopulatedOnlyWithValues()
    {
        $expected = 'value';
        
        $actual = $this->stub->add('value');

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function containerIsEmpty()
    {
        $actual = $this->stub->isEmpty();

        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function containerIsNotEmpty()
    {
        $this->stub->key = 'value';
        
        $actual = $this->stub->isEmpty();

        $this->assertFalse($actual);
    }
}

?>