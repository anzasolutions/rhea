<?php

namespace core\dao;

use core\db\exception\DuplicateException;

use app\model\Test;

use common\Mocker;
use common\TestAbstractDAO;

class AbstractDAOTest extends \PHPUnit_Framework_TestCase
{
    private $object;
    private $mocker;
    
    public function setUp()
    {
        $this->object = new TestAbstractDAO('Test');
        $this->mocker = new Mocker($this->object);
        
        $this->driver = $this->getMock('core\db\Driver');
        $this->query = $this->getMock('core\db\Query');
        $this->result = $this->getMock('core\db\Result');
        
        $this->mocker->mock('driver', $this->driver);
    }
    
    /**
     * @test
     */
    public function whenCountIsNotSpecificUseSimpleOne()
    {
        $expected = 1;
        
        $this->driver->expects($this->once())
                     ->method('createQuery')
                     ->will($this->returnValue($this->query));
                     
        $this->query->expects($this->once())
                    ->method('count');
                    
        $this->driver->expects($this->once())
                     ->method('getResult')
                     ->will($this->returnValue($this->result));

        $this->result->expects($this->once())
                     ->method('fetch')
                     ->with($this->equalTo('array'))
                     ->will($this->returnValue(array(1)));
             
        $actual = $this->object->count();
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @test
     */
    public function whenCountQueryIsGivenThenResultIsAsExpected()
    {
        $expected = 1;
        
        $this->driver->expects($this->once())
                     ->method('getResult')
                     ->will($this->returnValue($this->result));

        $this->result->expects($this->once())
                     ->method('fetch')
                     ->with($this->equalTo('array'))
                     ->will($this->returnValue(array(1)));
             
        $actual = $this->object->count($this->query);
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @test
     */
    public function findAllGivesProperResult()
    {
        $expected = array(new Test(1), new Test(2), new Test(3));
        
        $this->driver->expects($this->once())
                     ->method('createQuery')
                     ->will($this->returnValue($this->query));
                     
        $this->driver->expects($this->once())
                     ->method('getResult')
                     ->will($this->returnValue($this->result));

        $this->result->expects($this->once())
                     ->method('getSize')
                     ->will($this->returnValue(3));
                     
        for ($i = 1; $i < 4; $i++)
        {
            $row = new \stdClass();
            $row->test_id = $i;
            $row->test_value = '';
            
            $this->result->expects($this->at($i))
                         ->method('fetch')
                         ->will($this->returnValue($row));
        }

        $this->result->expects($this->at(4))
                     ->method('fetch')
                     ->will($this->returnValue(false));

        $this->result->expects($this->exactly(4))
                     ->method('fetch');

        $actual = $this->object->findAll();
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @test
     * @expectedException core\db\exception\NoResultException
     */
    public function findAllThrowsExceptionWhenNothingFound()
    {
        $this->driver->expects($this->once())
                     ->method('createQuery')
                     ->will($this->returnValue($this->query));
        
        $this->driver->expects($this->once())
                     ->method('getResult')
                     ->will($this->returnValue($this->result));

        $this->object->findAll();
    }
    
    /**
     * @test
     * @expectedException core\db\exception\IncorrectTypeException
     */
    public function deleteThrowsExceptionWhenAttemptToDeleteIncorrectType()
    {
        $this->object->delete('stdClass');
    }
    
    /**
     * @test
     */
    public function entityIsDeletedProperly()
    {
        $this->driver->expects($this->once())
                     ->method('createQuery')
                     ->will($this->returnValue($this->query));
        
        $this->query->expects($this->once())
                    ->method('delete');
        
        $this->driver->expects($this->once())
                     ->method('getResult')
                     ->will($this->returnValue($this->result));

        $this->result->expects($this->once())
                     ->method('getSize');

        $this->object->delete(new Test());
    }
    
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function findByIdWithNullIdThrowsAnException()
    {
        $this->object->findById(null);
    }
    
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function findByIdWithNotIntegerIdThrowsAnException()
    {
        $this->object->findById('something');
    }
    
    /**
     * @test
     */
    public function findByIdReturnsProperSingleResult()
    {
        $expected = new Test(1);
        
        $this->driver->expects($this->once())
                     ->method('createQuery')
                     ->will($this->returnValue($this->query));
        
        $this->driver->expects($this->once())
                     ->method('getResult')
                     ->will($this->returnValue($this->result));

        $this->result->expects($this->once())
                     ->method('getSize')
                     ->will($this->returnValue(1));

        $row = new \stdClass();
        $row->test_id = 1;
        $row->test_value = '';
        
        $this->result->expects($this->at(1))
                     ->method('fetch')
                     ->will($this->returnValue($row));

        $actual = $this->object->findById(1);
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @test
     */
    public function findByIdReturnsProperSingleResultWhenProvidedIdIsString()
    {
        $expected = new Test(1);
        
        $this->driver->expects($this->once())
                     ->method('createQuery')
                     ->will($this->returnValue($this->query));
        
        $this->driver->expects($this->once())
                     ->method('getResult')
                     ->will($this->returnValue($this->result));

        $this->result->expects($this->once())
                     ->method('getSize')
                     ->will($this->returnValue(1));

        $row = new \stdClass();
        $row->test_id = 1;
        $row->test_value = '';
        
        $this->result->expects($this->at(1))
                     ->method('fetch')
                     ->will($this->returnValue($row));

        $actual = $this->object->findById('1');
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @test
     * @expectedException core\db\exception\NonUniqueResultException
     */
    public function findByIdThrowsAnExceptionWhenNoSingleResult()
    {
        $this->driver->expects($this->once())
                     ->method('createQuery')
                     ->will($this->returnValue($this->query));
        
        $this->driver->expects($this->once())
                     ->method('getResult')
                     ->will($this->returnValue($this->result));

        $this->result->expects($this->once())
                     ->method('getSize')
                     ->will($this->returnValue(1));
                     
        for ($i = 1; $i < 3; $i++)
        {
            $row = new \stdClass();
            $row->test_id = $i;
            $row->test_value = '';
            
            $this->result->expects($this->at($i))
                         ->method('fetch')
                         ->will($this->returnValue($row));
        }

        $this->object->findById(1);
    }
    
    /**
     * @test
     * @expectedException core\db\exception\IncorrectTypeException
     */
    public function saveThrowsExceptionWhenAttemptToSaveIncorrectType()
    {
        $this->object->save('stdClass');
    }
    
    /**
     * @test
     */
    public function saveNewRecordAndReturnNumberOfAffectedRows()
    {
        $this->driver->expects($this->once())
                     ->method('createQuery')
                     ->will($this->returnValue($this->query));
                     
        $this->query->expects($this->once())
                    ->method('insert');
        
        $this->driver->expects($this->once())
                     ->method('getResult')
                     ->will($this->returnValue($this->result));
        
        $this->object->save(new Test());
    }
    
    /**
     * @test
     * @expectedException core\db\exception\DuplicateException
     */
    public function attemptToSaveDuplicateResultsInAnExceptionThrown()
    {
        $this->driver->expects($this->once())
                     ->method('createQuery')
                     ->will($this->returnValue($this->query));
                     
        $this->query->expects($this->once())
                    ->method('insert');
        
        $this->driver->expects($this->once())
                     ->method('execute')
                     ->will($this->throwException(new DuplicateException()));
                    
        $this->object->save(new Test());
    }
    
    /**
     * @test
     */
    public function saveExistingRecordAndReturnNumberOfAffectedRows()
    {
        $this->driver->expects($this->once())
                     ->method('createQuery')
                     ->will($this->returnValue($this->query));
                     
        $this->query->expects($this->once())
                    ->method('update');
        
        $this->driver->expects($this->once())
                     ->method('getResult')
                     ->will($this->returnValue($this->result));
        
        $this->object->save(new Test(1));
    }
}

?>