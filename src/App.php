<?php

namespace Source;

use Exceptions\RouteNotFoundException;
use Router\Router;

class App
{
    public function __construct(private Router $router, private string $requestUri, private string $requestMethod)
    {}

    public function run()
    {
        error_log('REQUEST_URI: ' . $this->requestUri . ' [' . $this->requestMethod . ']');
        try {
            echo $this->router->resolve($this->requestUri, $this->requestMethod);
        } catch (RouteNotFoundException $e) {
            echo $e->getMessage();
        }
    }
}