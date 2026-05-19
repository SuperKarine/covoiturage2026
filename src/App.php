<?php

namespace Source;

use Exceptions\RouteNotFoundException;
use Router\Router;

class App 
{
    
    public function __construct(private Router $router, private string $requestUri)
    {}
    
    public function run()
    {
        error_log('REQUEST_URI: ' . $this->requestUri);
        try {
            echo $this->router->resolve($this->requestUri);
        } catch (RouteNotFoundException $e) {
            echo $e->getMessage();
        }
    }
}