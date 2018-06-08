<?php

namespace Weborama\Routing;

use Weborama\Routing\Route;

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
                [request()->httpMethod]
            );
        }
    }

    // Get route name by truncating current request with SITE_URL
    public function currentRouteName()
    {
        return explode('?', $_SERVER["REQUEST_URI"])[0];
    }

    //run the current route
    public function run()
    {
        $result = $this->currentRoute->treatPattern();
        return $result;
    }

    private function protocolPrefix()
    {
        if (isset($_SERVER['HTTPS'])) {
            return 'https://';
        }
        return 'http://';
    }

    private function currentRoute()
    {
        return (new RouteParser)->getCurrentRoute($this->currentRouteName());
    }
}
