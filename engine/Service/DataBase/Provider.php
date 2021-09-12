<?php

namespace Engine\Service\DataBase;

use Engine\Core\DataBase\Connect;
use Engine\Service\AbstractProvider;

class Provider extends AbstractProvider
{
    public $serviceName = 'db';

    /**
     * @return void
     */
    public function init()
    {
        $settings = require ROOT_DIR . '/engine/Config/dbconfig.php';

        $db = new Connect($settings);

        $this->di->set($this->serviceName, $db);
    }
}
