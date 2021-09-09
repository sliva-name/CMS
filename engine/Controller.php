<?php


namespace Engine;


use Engine\DI\DI;

abstract class Controller
{
    /**
     * @var DI
     */
    protected $di;

    /**
     * @var
     */
    protected $db;

    /**
     * @var
     */
    protected $view;


    /**
     * Controller constructor.
     * @param $di
     */
    public function __construct($di)
    {
        $this->di = $di;
        $this->view = $this->di->get('view');
    }
}