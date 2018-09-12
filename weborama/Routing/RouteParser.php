<?php

namespace Weborama\Routing;

use Weborama\Routing\Route;

class RouteParser
{

    /**
     * Retrieve a route by its filled name
     */
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

    /**
     * Check if the current used HTTP method match the route HTTP method
     */
    private function verifyHttpMethod($route)
    {
        return in_array(request()->httpMethod, $route->methods);
    }

    /**
     * Check if a filled url match a route name 
     */
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

    /**
     * Tell if a string is parsable in a route name
     */
    private function isParsable($string)
    {
        if ($string[0] == '{' && $string[strlen($string) - 1] == '}') {
            return true;
        }
        return false;
    }
}
