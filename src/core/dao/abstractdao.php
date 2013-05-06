<?php

namespace core\dao;

use core\annotation\AnnotationClass;
use core\annotation\Annotation;
use core\constant\Space;
use core\db\DriverFactory;
use core\db\Query;
use core\db\constant\FetchType;
use core\db\exception\IncorrectTypeException;
use core\db\exception\NonUniqueResultException;
use core\db\exception\NoResultException;
use core\db\exception\QueryException;

abstract class AbstractDAO implements DAO
{
    protected $driver;
    protected $type;

    public function __construct($type)
    {
        $this->driver = DriverFactory::createDefault();
        $this->type = $type;
    }

    public function save($entity)
    {
        $this->isEntity($entity);
        $query = $this->driver->createQuery();
        $entity->getId() == null ? $query->insert($entity) : $query->update($entity);
        $this->execute($query);
    }
    
    private function isEntity($entity)
    {
        $class = new AnnotationClass($entity);
        if (!$class->hasAnnotation(Annotation::ENTITY))
        {
            throw new IncorrectTypeException($class->getName());
        }
    }

    /**
     * Execute provided query in order to return specific set of entities.
     * @param string $query Query to be executed.
     * @return array Number of entities for particular type of DAO.
     */
    private function execute(Query $query)
    {
        $objects = array();
        try
        {
            $this->driver->execute($query);
            $result = $this->driver->getResult();
            if ($result->getSize() > 0)
            {
                while ($row = $result->fetch())
                {
                    $objects[] = $this->map($this->type, $row);
                }
            }
        }
        catch (QueryException $e)
        {
            $e->getTraceAsString();
        }
        return $objects;
    }

    private function map($shortname, $object)
    {
        $fullname = Space::DB_MODEL . $shortname;
        $entity = new $fullname;
         
        $vars = get_object_vars($object);
         
        $class = new AnnotationClass($entity);
        $props = $class->getProperties();
        foreach ($props as $prop)
        {
            $propName = strtolower($prop->getName());
            if ($prop->hasAnnotation(Annotation::FETCH) &&
                $prop->getValueOf(Annotation::FETCH) == FetchType::EAGER)
            {
                $nameId = $propName . '_id';
                if (!array_key_exists($nameId, $vars))
                {
                    continue;
                }
                $value = $this->map($propName, $object);
            }
            else
            {
                $key = strtolower($shortname) . '_' . $propName;
                $value = $object->$key;
            }
            $setter = 'set' . $propName;
            $entity->$setter($value);
        }
        return $entity;
    }

    public function delete($entity)
    {
        $this->isEntity($entity);
        $query = $this->driver->createQuery();
        $query->delete();
        $query->from($this->type);
        $query->where('id', $entity->getId());
        $this->execute($query);
    }

    protected function singleResult(Query $query)
    {
        $result = $this->result($query);
        if (sizeof($result) > 1)
        {
            throw new NonUniqueResultException();
        }
        return $result[0];
    }

    protected function result(Query $query)
    {
        $result = $this->execute($query);
        // TODO: is there a serious reason to throw NoResultException
        // when in other ORM frameworks null is acceptable???
        if (sizeof($result) == 0)
        {
            throw new NoResultException();
        }
        return $result;
    }

    public function findById($id)
    {
        if ($id == null || !preg_match('/^\d+$/', $id))
        {
            throw new \InvalidArgumentException($id);
        }
        $query = $this->simpleFrom();
        $query->joinAll($this->type);
        $query->where($this->type.'.id', $id);
        return $this->singleResult($query);
    }

    protected function simpleCount()
    {
        $query = $this->driver->createQuery();
        $query->count($this->type . '.id');
        $query->from($this->type);
        return $query;
    }

    public function count(Query $query = null)
    {
        if ($query == null)
        {
            $query = $this->simpleCount();
        }
        $this->driver->execute($query);
        $result = $this->driver->getResult()->fetch('array');
        return $result[0];
    }

    public function findAll()
    {
        $query = $this->simpleFrom();
        $query->joinAll($this->type);
        return $this->result($query);
    }

    protected function simpleFrom()
    {
        $query = $this->driver->createQuery();
        $aliases = $query->buildAliases($this->type);
        $query->select($aliases);
        $query->from($this->type);
        return $query;
    }
}

?>