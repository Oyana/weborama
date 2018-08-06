<?php

namespace Weborama\Routing;

use Weborama\Routing\Route;
use Weborama\Helpers\Objects\Singletons;

class RouteCollection extends Singletons
{
    public static $available_methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

    public $routes = [];

    public function add($url, $pattern, array $methods = [])
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

    public function get($url, $pattern)
    {
        return $this->add($url, $pattern, ['GET']);
    }

    public function post($url, $pattern)
    {
        return $this->add($url, $pattern, ['POST']);
    }

    public function put($url, $pattern)
    {
        return $this->add($url, $pattern, ['PUT']);
    }

    public function patch($url, $pattern)
    {
        return $this->add($url, $pattern, ['PATCH']);
    }

    public function delete($url, $pattern)
    {
        return $this->add($url, $pattern, ['DELETE']);
    }

    private function checkMethodAvailability($methods)
    {
        foreach ($methods as $method) {
            if (!in_array($method, RouteCollection::$available_methods)) {
                throw new \Exception($method . " is not an available HTTP method", 1);
            }
        }
    }
}
