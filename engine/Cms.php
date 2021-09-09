<?php
namespace Engine;

use Engine\Application\Common;
use Engine\Core\Router\DispatchRoute;
use Exception;

class Cms
{
   private $di;
   private $router;

    /**
     * Cms constructor.
     * @param $di
     */
    public function __construct($di)
    {
        $this->di = $di;
        $this->router = $this->di->get('router');
    }

    /**
     * Run Cms
     */
    public  function run()
    {
        try {
            require_once __DIR__ . '/../application/Router.php';

            $routerDispach = $this->router->dispatch(Common::getMethod(), Common::getUrl ());

            if ($routerDispach == null)
            {
                $routerDispach = new DispatchRoute('ErrorController:page404');
            }

            list($class, $action) = explode (':', $routerDispach->getController(), 2);
            $controller = '\\Cms\\Controller\\' . $class;
            call_user_func_array ([new $controller($this->di), $action], $routerDispach->getParam());
        }
        catch (Exception $e)
        {
            exit($e->getMessage ());
        }
    }
}