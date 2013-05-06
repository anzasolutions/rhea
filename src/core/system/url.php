<?php

namespace core\system;

use core\constant\Separator;

/**
 * Contain URL request with actions.
 * @author anza
 * @version 2010-09-20
 */
class URL
{
    private static $instance;

    private $elements;
    private $controller = null;
    private $action = null;
    private $parameters = array();

    private function __construct()
    {
        if (isset($_GET['action']))
        {
            $this->elements = $this->trim($_GET['action']);
        }
         
        if ($this->hasElements())
        {
            $this->extractElements();
        }
    }

    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Trim URL from all unwanted characters.
     * @return string Trimmed URL elements.
     */
    private function trim($element)
    {
        return trim($element, ' /\\');
    }

    /**
     * Check base URL for controller, action and parameters.
     * @return boolean
     */
    private function hasElements()
    {
        return strlen($this->elements) > 0;
    }

    /**
     * Split URL into more meaningful elements.
     */
    private function extractElements()
    {
        $elements = $this->separateElements();

        if (isset($elements[0]))
        {
            $this->controller = $elements[0];
        }

        if (isset($elements[1]))
        {
            $this->action = $elements[1];
        }

        if (isset($elements[2]))
        {
            $this->parameters = array_slice($elements, 2);
        }
    }

    /**
     * Separate controller, action and parameters from string.
     * @return array Strings representing controller, action and parameters.
     */
    private function separateElements()
    {
        return explode(Separator::SLASH, $this->elements);
    }

    public function getController()
    {
        return $this->controller;
    }

    public function setController($controller)
    {
        $this->controller = $controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function setParameters()
    {
        $this->parameters = func_get_args();
    }

    public function getParameter($key)
    {
        if (isset($this->parameters[$key]))
        {
            return $this->parameters[$key];
        }
    }

    public function hasParameters()
    {
        return sizeof($this->parameters) > 0;
    }

    /**
     * Ocasionally it's more convinient to have in URL an action
     * on a first parameter position and the param on the action's.
     * But in order to process controller's action properly
     * the URL param action must be moved to a proper action position.
     * The URL action param will be moved to a first param position.
     */
    public function setParamAsAction()
    {
        $id = $this->action;
        $action = '';
        if ($this->hasParameters())
        {
            $action = $this->parameters[0];
        }
        $this->action = $action;
        $this->parameters[0] = $id;
    }

    public function setURL($controller, $action = null)
    {
        $this->setController($controller);
        $this->setAction($action);
    }
    
    public function __toString()
    {
        return $this->combine($this->controller, $this->action, $this->parameters);
    }

    public function build($controller = null, $action = null)
    {
        $parameters = array_slice(func_get_args(), 2);
        return $this->combine($controller, $action, $parameters);
    }
    
    private function combine($controller, $action, array $parameters = array(), $prefix = URL_APP)
    {
        $url = $prefix . $controller . Separator::SLASH . $action;
        foreach ($parameters as $parameter)
        {
            $url .= Separator::SLASH . $parameter;
        }
        return $url;
    }

    public function getActionPath($action = null, $prefix = '')
    {
        if ($action == null)
        {
            $action = $this->action;
        }
        return $this->combine($this->controller, $action, array(), $prefix);
    }
}

?>