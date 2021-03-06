<?php


namespace Engine\Service\Router;


use Engine\Core\Router\Router;
use Engine\Service\AbstractProvider;

class Provider extends AbstractProvider
{
    public $serviceName = 'router';

    /**
     * @return void
     */
    public function init()
    {
        $settings = require $_SERVER['DOCUMENT_ROOT'] . '/engine/Config/RouterConfig.php';

        $router = new Router($settings);

        $this->di->set($this->serviceName, $router);
    }

}