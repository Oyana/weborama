<?php

namespace Weborama\Routing;

class Route
{
    public $url;
    public $pattern;
    public $methods;
    public $fillableParameters = [];
    public $filledParameters = [];

    public function __construct($url, $pattern, $methods)
    {
        $this->url = $url;
        $this->pattern = $pattern;
        $this->methods = $methods;

        foreach (explode('/', $url) as $urlPartIndex => $urlPart) {
            if (!empty($urlPart) && $urlPart[0] == '{' && $urlPart[strlen($urlPart)-1] == '}') {
                $this->fillableParameters[$urlPartIndex] = $urlPart;
            }
        }
    }

    /**
     * Execute the pattern of the route, either a controller method or a closure
     */
    public function treatPattern()
    {
        //directly execute any closure
        if (is_object($this->pattern) && ($this->pattern instanceof \Closure)) {
            return $this->executePatternClosure();
        }

        //check if @ notation is used
        $parsedPattern = explode('@', $this->pattern);
        if (count($parsedPattern) == 2) {
            return $this->executePatternController($parsedPattern);
        }
    }
 
    /**
     * Execute the closure in the route
     */
    private function executePatternClosure()
    {
        $closure = $this->pattern;
        return $closure();
    }

    /**
     * Execute the controller method in the route
     * With the rightfully filled parameters 
     */
    private function executePatternController($parsedPattern)
    {
        $controllerName = CONTROLLERS_NAMESPACE . $parsedPattern[0];
        $controller = (new $controllerName);
        return $controller->{$parsedPattern[1]}(...$this->parametersValues($controller, $parsedPattern[1]));
    }

    /**
     * Fill the filledParameters array with the value inside the current URL
     */
    public function matchedWithUrl($currentUrl)
    {
        $parsedCurrentUrl = explode('/', $currentUrl);
        foreach ($this->fillableParameters as $index => $parameter) {
            $this->filledParameters[] = $parsedCurrentUrl[$index];
        }
    }

    /**
     * Create the value array to be pass to the controller method.
     * Those values will be object instance if the parameter is typehinted.
     */
    private function parametersValues($class, $method)
    {
        $values = [];
        foreach ($this->reflectMethodParameters($class, $method) as $index => $parameter) {
            if (null !== $parameter->getType()) {
                $objectTypeHintedName = $parameter->getType()->getName();
                $values[] = new $objectTypeHintedName($this->filledParameters[$index]);
            } else {
                if (isset($this->filledParameters[$index])) {
                    $values[] = $this->filledParameters[$index];
                }
            }
        }
        return $values;
    }

    /**
     * Get the parameters of a method in a class
     */
    private function reflectMethodParameters($class, $method)
    {
        return (new \ReflectionMethod($class, $method))->getParameters();
    }
}
