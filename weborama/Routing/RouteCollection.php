<?php

namespace Weborama\Routing;

use Weborama\Routing\Route;
use Weborama\Request\Request;
use Weborama\Helpers\Objects\Singletons;

class RouteCollection extends Singletons
{
    public $routes = [];

    /**
     * Instanciate a new route with an URL
     * an associated pattern (closure or controller method)
     * and an associated HTTP method (or multiple HTTP methods)
     */
    public function add($url, $pattern, $methods = [])
    {
        if (empty($methods)) {
            $methods = Request::$available_methods;
        }
        $this->checkMethodAvailability($methods);
        foreach ($methods as $method) {
            $this->routes[$method][$url] = new Route($url, $pattern, $methods);
        }

        return $this;
    }

    /**
     * Create a new route for a GET method 
     */
    public function get($url, $pattern)
    {
        return $this->add($url, $pattern, ['GET']);
    }

    /**
     * Create a new route for a POST method 
     */
    public function post($url, $pattern)
    {
        return $this->add($url, $pattern, ['POST']);
    }

    /**
     * Create a new route for a PUT method 
     */
    public function put($url, $pattern)
    {
        return $this->add($url, $pattern, ['PUT']);
    }

    /**
     * Create a new route for a PATCH method 
     */
    public function patch($url, $pattern)
    {
        return $this->add($url, $pattern, ['PATCH']);
    }

    /**
     * Create a new route for a DELETE method 
     */
    public function delete($url, $pattern)
    {
        return $this->add($url, $pattern, ['DELETE']);
    }

    /**
     * Check if the called method is allowed
     */
    private function checkMethodAvailability($methods)
    {
        foreach ($methods as $method) {
            if (!in_array($method, Request::$available_methods)) {
                throw new \Exception($method . " is not an available HTTP method", 1);
            }
        }
    }
}
