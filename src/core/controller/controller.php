<?php

namespace core\controller;

use core\service\ServicePool;
use core\system\Logger;
use core\system\URL;
use core\system\container\Request;
use core\system\container\Values;
use core\system\session\Session;
use core\util\Navigator;
use core\util\TextBundle;
use core\view\View;

abstract class Controller
{
    protected $session;
    protected $url;
    protected $service;
    protected $view;
    protected $request;
    protected $values;
    protected $bundle;
    protected $navigator;
    protected $log;

    /**
     * @PostConstruct
     */
    public function init()
    {
        $this->session = Session::getInstance();
        $this->url = URL::getInstance();
        $this->request = Request::getInstance();
        $this->values = Values::getInstance();
        $this->bundle = TextBundle::getInstance();
        $this->service = ServicePool::getInstance();
        $this->navigator = new Navigator();
        $this->log = Logger::getLogger($this);
    }

    /**
     * Default action of each controller.
     * Must be overriden in subclass' implementation.
     */
    protected abstract function index();

    /**
     * Handles 404 error.
     */
    protected function error()
    {
    }

    public function execute()
    {
        $handler = new ActionHandler($this);
        $action = $handler->getAction();
        $display = $handler->getDisplay();

        if ($handler->hasForm())
        {
            $methods = $handler->getBeforeFormMethods();
            foreach ($methods as $method)
            {
                $this->$method();
            }

            $form = $handler->getForm();
            if ($form != null && $form->isSent())
            {
                $this->$action($form);
            }
        }
        else
        {
            $this->$action();
        }

        $this->view->$display($action);
    }

    /**
     * To be called whenever error 404 should occur.
     */
    public function redirectToError()
    {
        $this->setAction('error');
    }

    protected function setAction($action)
    {
        $this->url->setAction($action);
        $this->execute();
        die();
    }

    protected function redirectTo($location = null)
    {
        $this->navigator->redirectTo($location);
    }

    public function __toString()
    {
        return get_class($this);
    }

    public function __set($key, $value)
    {
        $this->values->$key = $value;
    }

    public function __get($key)
    {
        return $this->values->$key;
    }
    
    public function setView(View $view)
    {
        $this->view = $view;
    }
}

?>