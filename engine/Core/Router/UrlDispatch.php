<?php

namespace Engine\Core\Router;

class UrlDispatch
{
    /**
     * @var string[]
     */
    private $methods = [
        'GET',
        'POST',
    ];

    /**
     * @var array[]
     */
    private $routes = [
        'GET' => [],
        'POST' => [],
    ];

    /**
     * @var string[]
     */
    private $patterns = [
        'int' => '[0-9]+',
        'str' => '[a-zA-Z\.\-_%]+',
        'any' => '[a-zA-Z0-9\.\-_%]+',
    ];

    /**
     * @param $key
     * @param $pattern
     */
    public function addPattern($key, $pattern)
    {
        $this->patterns[$key] = $pattern;
    }

    /**
     * @param $method
     * @return array
     */
    private function routes($method)
    {
        return $this->routes[$method] ?? [];
    }

    /**
     * @param $method
     * @param $pattern
     * @param $controller
     */
    public function register($method, $pattern, $controller)
    {
        $convert = $this->convertPattern($pattern);
        $this->routes[strtoupper($method)][$convert] = $controller;
    }

    /**
     * @param $pattern
     * @return array|mixed|string|string[]|null
     */
    private function convertPattern($pattern)
    {
        if (strpos($pattern, '(') === false) {
            return $pattern;
        } else {
            return preg_replace_callback('#\((\w+):(\w+)\)#', [$this, 'replacePattern'], $pattern);
        }
    }

    /**
     * @param $matches
     * @return string
     */
    private function replacePattern($matches): string
    {
        return '(?<' . $matches[1] . '>' . strtr($matches[2], $this->patterns) . ')';
    }

    /**
     * @param $param
     * @return mixed
     */
    private function processParam($param)
    {
        foreach ($param as $key => $value) {
            if (is_int($key)) {
                unset($param[$key]);
            }
        }
        return $param;
    }

    /**
     * @param $method
     * @param $url
     * @return DispatchRoute
     */
    public function dispatch($method, $url)
    {

        $routes = $this->routes(strtoupper($method));

        if (array_key_exists($url, $routes)) {
            return new DispatchRoute($routes[$url]);
        }
        return $this->doDispatch($method, $url);
    }
    private function doDispatch($method, $url)
    {
        foreach ($this->routes($method) as $route => $controller) {
            $pattern = '#' . $route . '$#s';
            if (preg_match($pattern, $url, $param)) {
                return new DispatchRoute($controller, $this->processParam($param));
            }
        }
    }

    /**
     * @return string[]
     */
    public function getPatterns()
    {
        return $this->patterns;
    }
}
