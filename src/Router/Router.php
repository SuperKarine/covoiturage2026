<?php

namespace Router;

use Exceptions\RouteNotFoundException;

class Router
{
    private array $routes = [];

    
     // Enregistre une route pour une méthode HTTP donnée.
     
    public function register(string $method, string $path, callable|array $action): void
    {
        $method = strtoupper($method);
        $this->routes[$method][$path] = $action;
    }

    public function resolve(string $uri, string $method): mixed
    {
        $path = explode('?', $uri)[0];
        $method = strtoupper($method);

        $routesPourMethode = $this->routes[$method] ?? [];

        foreach ($routesPourMethode as $registeredPath => $action) {
            $params = $this->matchPath($registeredPath, $path);

            if ($params !== null) {
                return $this->callAction($action, $params);
            }
        }

        throw new RouteNotFoundException();
    }

    /**
     * Compare un chemin enregistré 
     * Renvoie un tableau de paramètres extraits si ça correspond,
     * ou null si ça ne correspond pas.
     */
    private function matchPath(string $registeredPath, string $actualPath): ?array
    {
        $registeredParts = explode('/', trim($registeredPath, '/'));
        $actualParts = explode('/', trim($actualPath, '/'));

        if (count($registeredParts) !== count($actualParts)) {
            return null;
        }

        $params = [];

        foreach ($registeredParts as $i => $part) {
            if (preg_match('/^\{(.+)\}$/', $part, $matches)) {
                
                $params[$matches[1]] = $actualParts[$i];
            } elseif ($part !== $actualParts[$i]) {
                
                return null;
            }
        }

        return $params;
    }

    private function callAction(callable|array $action, array $params): mixed
    {
        if (is_callable($action)) {
            return call_user_func_array($action, $params);
        }

        if (is_array($action)) {
            [$className, $methodName] = $action;

            if (class_exists($className) && method_exists($className, $methodName)) {
                $class = new $className();
                return call_user_func_array([$class, $methodName], $params);
            }
        }

        throw new RouteNotFoundException();
    }
}