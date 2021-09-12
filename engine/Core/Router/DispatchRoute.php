<?php

namespace Engine\Core\Router;

class DispatchRoute
{
    /**
     * @var
     */
    private $controller;
    /**
     * @var
     */
    private $param;

    /**
     * DispatchRoute constructor.
     * @param $controller
     * @param $param
     */
    public function __construct($controller, $param = [])
    {
        $this->controller = $controller;
        $this->param = $param;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return mixed
     */
    public function getParam()
    {
        return $this->param;
    }
}
