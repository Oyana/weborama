<?php

namespace Weborama\Routing;

use Weborama\Routing\Route;

class RouteParser
{
    public function getCurrentRoute($currentRouteName)
    {
        $matchingRoutes = [];

        foreach (routes()->routes as $route) {
            if ($this->urlParsedMatchRequest($route->url, $currentRouteName)) {
                if ($route->url == $currentRouteName && $this->verifyHttpMethod($route)) {
                    $matchingRoutes[] = $route;
                }
            }
        }
        //return only the first matching route
        return reset($matchingRoutes);
    }

    private function verifyHttpMethod($route)
    {
        return in_array(request()->httpMethod, $route->methods);
    }

    private function urlParsedMatchRequest($routeUrl, $requestUrl)
    {
        $requestParts = explode('/', $requestUrl);
        $routeParts = explode('/', $routeUrl);

        if (count($requestParts) !== count($routeParts)) {
            return false;
        }

        foreach ($routeParts as $i => $routePart) {
            if ($requestParts[$i] !== $routePart && !$this->isParsable($routePart)) {
                return false;
            }
        }

        return true;
    }

    private function isParsable($string)
    {
        if ($string[0] == '{' && $string[strlen($string)-1] == '}') {
            return true;
        }
        return false;
    }
}
