<?php

namespace Engine\Service\View;

use Engine\Core\Template\View;
use Engine\Service\AbstractProvider;

class Provider extends AbstractProvider
{
    public $serviceName = 'view';

    /**
     * @return void
     */
    public function init()
    {
        $view = new View();
        $this->di->set($this->serviceName, $view);
    }
}
