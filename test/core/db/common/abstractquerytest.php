<?php

namespace core\db\common;

use app\model\Test;
use app\model\Value;

class AbstractQueryTest extends \PHPUnit_Framework_TestCase
{
    private $driver;
    private $stub;
    
    public function setUp()
    {
        $this->driver = $this->getMockBuilder('core\db\Driver')->disableOriginalConstructor()->getMock();
        $this->stub = $this->getMockForAbstractClass('core\db\common\AbstractQuery', array($this->driver));
    }

    /**
     * @test
     */
    public function whenSelectIsCalledWithoutColumnsProvidedOnlySelectSqlKeywordIsAdded()
    {
        $expected = 'SELECT *';

        $actual = $this->stub->select();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function selectKeywordWithProvidedColumnsIsAddedToAQuery()
    {
        $columns = 'userId, login, password';
        $expected = 'SELECT ' . $columns;

        $actual = $this->stub->select($columns);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function whenDistinctIsCalledWithoutColumnsProvidedOnlySelectDistinctSqlKeywordIsAdded()
    {
        $expected = 'SELECT DISTINCT *';

        $actual = $this->stub->distinct();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function selectDistinctKeywordsWithProvidedColumnsAreAddedToAQuery()
    {
        $columns = 'userId, login, password';
        $expected = 'SELECT DISTINCT ' . $columns;

        $actual = $this->stub->distinct($columns);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function whenCountIsCalledWithoutColumnsProvidedOnlySelectCountSqlKeywordIsAdded()
    {
        $expected = 'SELECT COUNT(*)';

        $actual = $this->stub->count();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function selectCountKeywordsWithProvidedColumnsAreAddedToAQuery()
    {
        $columns = 'userId, login, password';
        $expected = 'SELECT COUNT(' . $columns . ')';

        $actual = $this->stub->count($columns);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function fromKeywordWithTablesIsAddedToAQuery()
    {
        $columns = 'user, profile';
        $expected = ' FROM ' . $columns;

        $actual = $this->stub->from($columns);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function whenNoOperatorIsProvidedForWhereKeywordDefaultOperatorIsAdded()
    {
        $condition = 'andy';
        $expected = ' WHERE userId = \''.$condition.'\'';

        $this->driver->expects($this->once())
                     ->method('escape')
                     ->will($this->returnValue($condition));

        $actual = $this->stub->where('userId', $condition);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function whereKeywordWithLikeOperatorIsAdded()
    {
        $condition = 'an%';
        $expected = ' WHERE userId LIKE \''.$condition.'\'';

        $this->driver->expects($this->once())
                     ->method('escape')
                     ->will($this->returnValue($condition));

        $actual = $this->stub->where('userId', $condition, $this->stub->like());

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function whereKeywordWithInOperatorIsAdded()
    {
        $collection = '\'andy\', \'mandy\', \'randy\'';
        $expected = ' WHERE userId IN ('.$collection.')';

        $actual = $this->stub->where('userId', $collection, $this->stub->in());

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function whereKeywordWithLessOperatorIsAdded()
    {
        $condition = '55';
        $expected = ' WHERE userId < \''.$condition.'\'';

        $this->driver->expects($this->once())
                     ->method('escape')
                     ->will($this->returnValue($condition));

        $actual = $this->stub->where('userId', $condition, $this->stub->less());

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function whereKeywordWithMoreOperatorIsAdded()
    {
        $condition = '55';
        $expected = ' WHERE userId > \''.$condition.'\'';

        $this->driver->expects($this->once())
                     ->method('escape')
                     ->will($this->returnValue($condition));

        $actual = $this->stub->where('userId', $condition, $this->stub->more());

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function whenNoOperatorIsProvidedForAndKeywordDefaultOperatorIsAdded()
    {
        $condition = 'andy';
        $expected = ' AND userId = \''.$condition.'\'';

        $this->driver->expects($this->once())
                     ->method('escape')
                     ->will($this->returnValue($condition));

        $actual = $this->stub->add('userId', $condition);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function whenNoOperatorIsProvidedForAndKeywordWithTwoColumnsDefaultOperatorIsAdded()
    {
        $condition = 'profileId';
        $expected = ' AND userId = '.$condition;

        $actual = $this->stub->addColumns('userId', $condition);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function whenNoOperatorIsProvidedForOrKeywordDefaultOperatorIsAdded()
    {
        $condition = 'andy';
        $expected = ' OR userId = \''.$condition.'\'';

        $this->driver->expects($this->once())
                     ->method('escape')
                     ->will($this->returnValue($condition));

        $actual = $this->stub->other('userId', $condition);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function orderByKeywordWithColumnsIsAdded()
    {
        $columns = 'userId, firstname';
        $expected = ' ORDER BY '.$columns;

        $actual = $this->stub->orderBy($columns);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function ascKeywordIsAdded()
    {
        $expected = ' ASC';

        $actual = $this->stub->asc();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function descKeywordIsAdded()
    {
        $expected = ' DESC';

        $actual = $this->stub->desc();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function deleteKeywordIsAdded()
    {
        $expected = 'DELETE ';

        $actual = $this->stub->delete();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function updateKeywordWithAllColumnsIsProperlyAddedToQuery()
    {
        $expected = 'UPDATE Test SET id = \'55\', valueId = \'66\' WHERE id = 55';
        
        $object = new Test();
        $object->setId(55);
        $object->setValue(new Value());
        
        $this->driver->expects($this->at(0))
                     ->method('escape')
                     ->will($this->returnValue('55'));
        
        $this->driver->expects($this->at(1))
                     ->method('escape')
                     ->will($this->returnValue('66'));
        
        $actual = $this->stub->update($object);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function insertKeywordWithAllColumnsIsProperlyAddedToQuery()
    {
        $expected = 'INSERT INTO Test (id, valueId) VALUES (\'55\', \'66\')';
        
        $object = new Test();
        $object->setId(55);
        $object->setValue(new Value());
        
        $this->driver->expects($this->at(0))
                     ->method('escape')
                     ->will($this->returnValue('55'));
        
        $this->driver->expects($this->at(1))
                     ->method('escape')
                     ->will($this->returnValue(66));
        
        $actual = $this->stub->insert($object);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function innerJoinKeywordWithoutAliasesIsAddedToQuery()
    {
        $expected = ' INNER JOIN test ON test.id = user.testid';
        
        $actual = $this->stub->join('test', 'user', false);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function innerJoinKeywordWithAliasesIsAddedToQuery()
    {
        $expected = ', test.id AS test_id INNER JOIN test ON test.id = user.testid';
        
        $actual = $this->stub->join('test', 'user');

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function innerJoinKeywordWithAllAliasesIsAddedToQuery()
    {
        $expected = ', role.id AS role_id, role.name AS role_name INNER JOIN role ON role.id = user.roleid';
        
        $actual = $this->stub->joinAll('user');

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function simpleSelectQueryIsCreated()
    {
        $expected = 'SELECT product.id AS product_id, product.name AS product_name, product.description AS product_description, product.price AS product_price, productcategory.id AS productcategory_id, productcategory.name AS productcategory_name, productcategory.parentid AS productcategory_parentid FROM product INNER JOIN productCategory ON productCategory.id = product.productCategoryid ORDER BY price DESC';
        
        $aliases = $this->stub->buildAliases('product');
        $this->stub->select($aliases);
        $this->stub->from('product');
        $this->stub->join('productCategory', 'product');
        $this->stub->orderBy('price');
        $actual = $this->stub->desc();

        $this->assertEquals($expected, $actual);
    }
}

?>