<?php

namespace Weborama\Routing;

use Weborama\Routing\Route;

class RouteCollection
{
    public static $available_methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

    public $routes = [];

    private function __construct()
    {
    }

    /**
     *Get an instance of the singleton
     *@return self
     */
    public static function instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new self();
        }
        return $inst;
    }

    public function add($url, $pattern, array $methods = [])
    {
        if (empty($methods)) {
            $methods = $this::$available_methods;
        }
        $this->checkMethodAvailability($methods);
        $this->routes[] = new Route($url, $pattern, $methods);
    }

    public function get($url, $pattern)
    {
        $this->add($url, $pattern, ['GET']);
    }

    public function post($url, $pattern)
    {
        $this->add($url, $pattern, ['POST']);
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
