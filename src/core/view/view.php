<?php

namespace core\view;

use core\system\URL;
use core\system\container\Request;
use core\system\container\Values;
use core\system\template\Template;
use core\util\TextBundle;

/**
 * Default view.
 * Should be extended by all views.
 * @author anza
 * @version 03-10-2010
 */
abstract class View
{
    protected $template;
    protected $url;
    protected $request;
    protected $values;
    protected $bundle;

    public function __construct()
    {
        $this->url = URL::getInstance();
        $this->template = new Template();
        $this->request = Request::getInstance();
        $this->values = Values::getInstance();
        $this->bundle = TextBundle::getInstance();
    }

    public function display($action)
    {
        $this->header();
        $this->$action();
        $this->footer();
    }

    public function displayBare($action)
    {
        $this->$action();
    }

    public function header()
    {
        $this->template->show(__FUNCTION__);
    }

    public function index()
    {
        $this->template->show(__FUNCTION__);
    }

    public function footer()
    {
        $this->template->show(__FUNCTION__);
    }

    public function error()
    {
        $this->template->show(__FUNCTION__);
    }

    public function __set($key, $value)
    {
        $this->values->$key = $value;
    }

    public function __get($key)
    {
        return $this->values->$key;
    }
}

?>