<?php

namespace core\db\common;

use core\annotation\AnnotationClass;
use core\annotation\Annotation;
use core\constant\Space;
use core\db\Driver;
use core\db\Query;

abstract class AbstractQuery implements Query
{
    protected $driver;
    protected $query;

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }

    public function select($columns = null)
    {
        $this->basicSelect($columns);
        $this->query .= $columns;
        return $this;
    }
    
    private function basicSelect(&$columns)
    {
        $columns = $columns == null ? '*' : $columns;
        $this->query .= 'SELECT ';
    }

    public function distinct($columns = null)
    {
        $this->basicSelect($columns);
        $this->query .= 'DISTINCT '.$columns;
        return $this;
    }

    public function count($columns = null)
    {
        $this->basicSelect($columns);
        $this->query .= 'COUNT('.$columns.')';
        return $this;
    }

    public function from($tables)
    {
        $this->query .= ' FROM '.strtolower($tables);
        return $this;
    }

    public function where($column, $condition, $operator = null)
    {
        $this->buildCondition(' WHERE ', $column, $condition, $operator);
        return $this;
    }

    public function add($column, $condition, $operator = null)
    {
        $this->buildCondition(' AND ', $column, $condition, $operator);
        return $this;
    }

    public function addColumns($column1, $column2, $operator = null)
    {
        $this->buildColumns(' AND ', $column1, $column2, $operator);
        return $this;
    }

    // TODO: there should be 2 versions of other method:
    // 1. that will use: (columns condition OR column condition)
    // 2. that will use: columns condition OR column condition
    public function other($column, $condition, $operator = null)
    {
        $this->buildCondition(' OR ', $column, $condition, $operator);
        return $this;
    }

    // TODO: this must be improved to allow column as condition not to be escaped!
    private function buildColumns($type, $column1, $column2, $operator = null)
    {
        $operator = $operator == null ? '=' : $operator;
        $this->query .= $type.$column1.' '.$operator.' '.$column2;
    }

    // TODO: this must be improved to allow column as condition not to be escaped!
    private function buildCondition($type, $column, $condition, $operator = null)
    {
        if ($operator == $this->in())
        {
            $condition = '('.$condition.')';
        }
        
        if (is_string($condition) && $operator != $this->in())
        {
            $condition = '\''.$this->driver->escape($condition).'\'';
        }
        $operator = $operator == null ? '=' : $operator;
        $this->query .= $type.$column.' '.$operator.' '.$condition;
    }

    public function orderBy($columns)
    {
        $this->query .= ' ORDER BY '.$columns;
        return $this;
    }

    public function desc()
    {
        $this->query .= ' DESC';
        return $this;
    }

    public function asc()
    {
        $this->query .= ' ASC';
        return $this;
    }
    
    public function update($object)
    {
        $class = new AnnotationClass($object);
        $properties = $this->getProperties($object, $class);
        foreach ($properties as $name => $value)
        {
            isset($values) ? $values .= ', ' : $values = '';
            $values .= $name.' = \''.$this->driver->escape($value).'\'';
        }
        $this->query = 'UPDATE '.$class->getShortName().' SET '.$values;
        $this->where('id', $object->getId());
        return $this;
    }

    private function getProperties($object, AnnotationClass $class)
    {
        $properties = $class->getProperties();
        foreach ($properties as $property)
        {
            $reflectionProperty = $property->getObject();
            $reflectionProperty->setAccessible(true);
            $value = $reflectionProperty->getValue($object);
            $name = $property->getName();
            if ($property->hasAnnotation(ucfirst($name)))
            {
                $name .= 'Id';
                $value = $value->getId();
            }
            $result[$name] = $value;
        }
        return $result;
    }

    public function insert($object)
    {
        $class = new AnnotationClass($object);
        $properties = $this->getProperties($object, $class);
        $columns = implode(', ', array_keys($properties));
        foreach ($properties as $value)
        {
            isset($values) ? $values .= ', ' : $values = '';
            $values .= '\''.$this->driver->escape($value).'\'';
        }
        $this->query = 'INSERT INTO '.$class->getShortName().' ('.$columns.') VALUES ('.$values.')';
        return $this;
    }

    public function delete()
    {
        $this->query .= 'DELETE ';
        return $this;
    }

    public function join($table, $type, $withAliases = true)
    {
        if ($withAliases)
        {
            $aliases = ', ' . $this->buildAliases($table);
            $fromPos = strrpos($this->query, ' FROM ');
            $this->query = substr_replace($this->query, $aliases, $fromPos, 0);
        }
        $this->query .= ' INNER JOIN '.$table.' ON '.$table.'.id = '.$type.'.'.$table.'id';
        return $this;
    }

    public function buildAliases($table, $types = array())
    {
        $aliases = '';
        $selectedAliases = '';
        
        $class = new AnnotationClass(Space::DB_MODEL . ucfirst($table));
        $props = $class->getProperties();
        $table = strtolower($table);
        foreach ($props as $prop)
        {
            if (!$prop->hasAnnotation(Annotation::FETCH))
            {
                $propName = strtolower($prop->getName());
                $aliases .= $table.'.'.$propName.' AS '.$table.'_'.$propName.', ';
            }
            else
            {
                // TODO: array('all') looks ok, but it should be improved
                if (!(sizeof($types) == 1 && $types[0] == 'all'))
                {
                    if (!in_array($prop->getName(), $types))
                    {
                        continue;
                    }
                }
                $propName = strtolower($prop->getName());
                //FIXME: is this a bug??? where's that method???
                $selectedAliases .= $this->buildSelectedAliases($propName, $types);
            }
        }
         
        return substr_replace($aliases . $selectedAliases, '', -2);
    }

    public function joinAll($table)
    {
        $joins = '';
        $class = new AnnotationClass(Space::DB_MODEL . ucfirst($table));
        $fetchProps = $class->getProperties(Annotation::FETCH);
        foreach ($fetchProps as $prop)
        {
            $propName = strtolower($prop->getName());
            $joins .= $this->join($propName, $table) . $this->joinAll($propName);
        }
        return $joins;
    }
    
    public function like()
    {
        return 'LIKE';
    }
    
    public function in()
    {
        return 'IN';
    }
    
    public function less()
    {
        return '<';
    }
    
    public function more()
    {
        return '>';
    }

    public function __toString()
    {
        return $this->query;
    }
}

?>