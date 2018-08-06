<?php

namespace Weborama\Routing;

use Weborama\Routing\Route;

class RouteParser
{
    public function getCurrentRoute($currentRouteName)
    {
        $matchingRoutes = [];
        $applicableRoutes = routes()->routes[request()->httpMethod];
        if (!empty($applicableRoutes[$currentRouteName])) {
            return $applicableRoutes[$currentRouteName];
        } else {
            foreach ($applicableRoutes as $name => $route) {
                if ($this->urlParsedMatchRequest($route->url, $currentRouteName)) {
                    $route->matchedWithUrl($currentRouteName);
                    return $route;
                }
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
