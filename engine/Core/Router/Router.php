<?php

namespace Engine\Core\Router;

class Router
{
    /**
     * @var array
     */
    protected $routes = [];
    /**
     * @var
     */
    private $dispatch;
    /**
     * @var
     */
    protected $host;

    /**
     * Router constructor.
     * @param $host
     */
    public function __construct($host)
    {
        $this->host = $host;
    }
    public function add($key, $pattern, $controller, $method = 'GET')
    {
        $this->routes[$key] = [
            'pattern' => $pattern,
            'controller' => $controller,
            'method' => $method,
        ];
    }
    public function dispatch($method, $url)
    {
        return $this->getDispatch()->dispatch($method, $url);
    }
    private function getDispatch()
    {
        if ($this->dispatch === null) {
            $this->dispatch = new UrlDispatch();
            foreach ($this->routes as $route) {
                $this->dispatch->register($route['method'], $route['pattern'], $route['controller']);
            }
        }
        return $this->dispatch;
    }
}
