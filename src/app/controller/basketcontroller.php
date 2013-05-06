<?php

namespace app\controller;

use core\controller\Controller;

/**
 * @Session
 */
class BasketController extends Controller
{
    /**
     * @Invocable
     */
    protected function index()
    {
        $this->setAction('cart');
    }

    /**
     * @Invocable
     */
    protected function cart()
    {
    }

    /**
     * @Invocable
     */
    protected function add()
    {
    }

    /**
     * @Invocable
     */
    protected function checkout()
    {
    }
}

?>