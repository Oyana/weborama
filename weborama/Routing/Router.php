<?php

namespace Weborama\Routing;

use Route;

/*
|-------------------------------------------------------
| Handle Routes
|-------------------------------------------------------
|
| Parse the current URL to find which route to call.
| This is the main routing function, instantiating
| automatically the required controller and call it.
|
*/

class Router
{
    public $currentRoute;

    public function __construct()
    {
        $this->currentRoute = $this->currentRoute();
        if (null == $this->currentRoute) {
            $this->currentRoute = new Route(
                $this->currentRouteName(),
                function () {
                    view('errors/404');
                },
                [request()->httpMethod()]
            );
        }
    }

    // Get route name by truncating current request with SITE_URL
    public function currentRouteName()
    {
        return str_replace(SITE_URL, '', $this->protocolPrefix() . $_SERVER["HTTP_HOST"] . strtok($_SERVER["REQUEST_URI"], '?'));
    }

    //run the current route
    public function run()
    {
        $this->currentRoute->treatPattern();
    }

    private function protocolPrefix() : string
    {
        if (isset($_SERVER['HTTPS'])) {
            return 'https://';
        }
        return 'http://';
    }

    private function currentRoute()
    {
        $routes = array_filter(routes()->routes, function ($route) {
            return ($route->url == $this->currentRouteName() && $this->verifyHttpMethod($route));
        });

        //return only the first matching route
        return reset($routes);
    }

    private function verifyHttpMethod($route)
    {
        return in_array(request()->httpMethod(), $route->methods);
    }
}
