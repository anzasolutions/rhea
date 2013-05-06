<?php

namespace core\controller;

use core\annotation\AnnotationClass;
use core\annotation\Annotation;
use core\constant\Separator;
use core\system\URL;

class ControllerFactory
{
    private $controller;

    public function __construct()
    {
        $url = URL::getInstance();
        $this->controller = $url->getController();
    }

    public function create($name = null)
    {
        if ($name != null)
        {
            $this->controller = $name;
        }
        $controller = $this->getController();
        $view = $this->getView();
        $object = new $controller();
        $object->setView(new $view());
        $this->postConstruct($object);
        return $object; 
    }

    private function get($type)
    {
        return 'app' . Separator::BACKSLASH . $type . Separator::BACKSLASH . $this->controller . $type;
    }

    public function getController()
    {
        return $this->get('Controller');
    }

    public function getView()
    {
        return $this->get('View');
    }
    
    private function postConstruct($object)
    {
		$class = new AnnotationClass($object);
		$methods = $class->getMethods(Annotation::POST_CONSTRUCT);
		foreach ($methods as $method)
		{
		    $name = $method->getName();
		    $object->$name();
		}
    }
}

?>