<?php

namespace app\controller;

use core\controller\Controller;

abstract class ItemController extends Controller
{
    protected $id;

    /**
     * Set username from URL's action.
     * First parameter is set as action.
     * 
     * @PostConstruct
     */
    public function init()
    {
        parent::init();
        $this->url->setParamAsAction();
        $this->id = $this->url->getParameter(0);
    }
}

?>