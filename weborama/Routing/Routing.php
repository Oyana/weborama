<?php

namespace Weborama\Routing;

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

class Routing
{
    private $routingFallback;

    public function __construct()
    {
        $this->routingFallback = ROUTING_FALLBACK;
    }

    // Get route name by truncating current request with SITE_URL
    public function currentRouteName()
    {
        return str_replace(SITE_URL, '', $this->protocolPrefix() . $_SERVER["HTTP_HOST"] . strtok($_SERVER["REQUEST_URI"], '?'));
    }

    public function protocolPrefix()
    {
        if (isset($_SERVER['HTTPS'])) {
            return 'https://';
        }
        return 'http://';
    }

    // Get the route value related to the current route name
    public function getCurrentRouteOperator()
    {
        if (!isset($routes[$this->currentRouteName()])) {
            Debugger::throw("No route found on " . $this->currentRouteName());
        }
        return $routes[$this->currentRouteName()] ?? null;
    }
}

//display error or 404 if the route is not defined
if (isset($routes[$current_route])) {
    //initiate variable
    $controller = explode('@', $routes[$current_route])[0];
    $controllerName = ucfirst($controller);
    $method = explode('@', $routes[$current_route])[1];
    //handle resource & autoload

    $controllerName = new $controllerName;
    //handle POST & GET request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $method = 'post' . ucfirst($method);
    }
    //load & unset potential redirected datas
    if (isset($_SESSION['redirect'])) {
        $datas = $_SESSION['redirect'];
        unset($_SESSION['redirect']);
        $controllerName->$method($datas);
    } else {
        $controllerName->$method();
    }
} else {
    if (DEBUG_LVL > 0) {
        debug("No route found on $current_route");
    } else {
        include('views/errors/404.php');
    }
}
