<?php


namespace Engine\Service\DataBase;


use Engine\Service\AbstractProvider;
use Engine\Core\DataBase\Connect;

class Provider extends AbstractProvider
{
public $serviceName = 'db';

    /**
     * @return void
     */
    public function init()
    {
        $settings = require $_SERVER['DOCUMENT_ROOT'] . '/engine/Config/dbconfig.php';

        $db = new Connect($settings);

        $this->di->set($this->serviceName, $db);
    }

}