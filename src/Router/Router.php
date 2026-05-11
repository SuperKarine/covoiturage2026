<?php

namespace Router;

use Exceptions\RouteNotFoundException;

class Router 
{
    private array $routes = [];

    public function register(string $path, callable|array $action): void
    {
        $this->routes[$path] = $action;
    }

    public function resolve(string $uri): mixed
    {

        echo "ROUTER HIT<br>";   
        var_dump($uri);
        var_dump($this->routes);
        exit;

        $path = rtrim(parse_url($uri, PHP_URL_PATH), '/');

        if ($path === '') {
            $path = '/';
        }

        $action = $this->routes[$path] ?? null;

        if (!$action) {
            throw new RouteNotFoundException();
        }

        if (is_callable($action)) {
            return $action();
        }

        if (is_array($action)) {

            [$className, $method] = $action;

            if (!class_exists($className)) {
                throw new RouteNotFoundException("Class not found: $className");
            }

            $class = new $className();

            if (!method_exists($class, $method)) {
                throw new RouteNotFoundException("Method not found: $method");
            }

            return $class->$method();
        }

        throw new RouteNotFoundException();
    }
}