<?php

namespace Weborama\Routing;

use Weborama\Routing\Route;
use Weborama\Helpers\Objects\Singletons;

class RouteCollection extends Singletons
{
    public static $available_methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

    public $routes = [];

    /**
     * Instanciate a new route with an URL
     * an associated pattern (closure or controller method)
     * and an associated HTTP method (or multiple HTTP methods)
     */
    public function add(string $url, string $pattern, array $methods = [])
    {
        if (empty($methods)) {
            $methods = $this::$available_methods;
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
    public function get(string $url, string $pattern)
    {
        return $this->add($url, $pattern, ['GET']);
    }

    /**
     * Create a new route for a POST method 
     */
    public function post(string $url, string $pattern)
    {
        return $this->add($url, $pattern, ['POST']);
    }

    /**
     * Create a new route for a PUT method 
     */
    public function put(string $url, string $pattern)
    {
        return $this->add($url, $pattern, ['PUT']);
    }

    /**
     * Create a new route for a PATCH method 
     */
    public function patch(string $url, string $pattern)
    {
        return $this->add($url, $pattern, ['PATCH']);
    }

    /**
     * Create a new route for a DELETE method 
     */
    public function delete(string $url, string $pattern)
    {
        return $this->add($url, $pattern, ['DELETE']);
    }

    /**
     * Check if the called method is allowed
     */
    private function checkMethodAvailability($methods)
    {
        foreach ($methods as $method) {
            if (!in_array($method, RouteCollection::$available_methods)) {
                throw new \Exception($method . " is not an available HTTP method", 1);
            }
        }
    }
}
