<?php

namespace core\system;

use core\annotation\AnnotationClass;
use core\controller\ControllerFactory;
use core\system\session\Session;
use core\system\session\SessionUser;

class Router
{
    private $url;
    private $log;

    public function __construct()
    {
        $this->url = URL::getInstance();
        $this->log = Logger::getLogger($this);
    }

    public function route()
    {
        try
        {
            if ($this->url->getController() == null)
            {
                $this->setDefaultRoute();
            }

            $factory = new ControllerFactory();
            $controller = $factory->getController();
            $class = new AnnotationClass($controller);
            $current = Context::getCurrent();
            if ($class->hasOneOfAnnotations(Context::APPLICATION, $current))
            {
                $user = SessionUser::getInstance();
                if ($user->hasPrivilege($class))
                {
                    return;
                }
            }
        }
        catch (\LogicException $e)
        {
            $this->log->error($e);
        }
        catch (\ReflectionException $e)
        {
            $this->log->error($e);
        }

        $this->url->setURL(DEFAULT_APPLICATION_CONTROLLER, 'error');
    }

    private function setDefaultRoute()
    {
        $session = Session::getInstance();
        $session->isStarted() ? $this->setSessionDefaultRoute() : $this->setRequestDefaultRoute();
    }

    private function setSessionDefaultRoute()
    {
        $this->url->setURL(DEFAULT_SESSION_CONTROLLER, DEFAULT_SESSION_ACTION);
    }

    private function setRequestDefaultRoute()
    {
        $this->url->setURL(DEFAULT_REQUEST_CONTROLLER, DEFAULT_REQUEST_ACTION);
    }
}

?>