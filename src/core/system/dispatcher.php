<?php

namespace core\system;

use core\controller\ControllerFactory;

class Dispatcher
{
    public static function dispatch()
    {
        $router = new Router();
        $router->route();
        
        $factory = new ControllerFactory();
        $controller = $factory->create();
        $controller->execute();
    }
}

?>