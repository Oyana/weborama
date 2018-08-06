<?php

namespace Weborama\Routing;

use Weborama\Routing\Route;

class RouteParser
{
    public function getCurrentRoute($currentRouteName)
    {
        $matchingRoutes = [];
        $matchedRoute = routes()->routes[request()->httpMethod][$currentRouteName];
        if ($this->urlParsedMatchRequest($matchedRoute->url, $currentRouteName)) {
            if ($matchedRoute->url == $currentRouteName && $this->verifyHttpMethod($matchedRoute)) {
                return $matchedRoute;
            }
        }
        return false;
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
