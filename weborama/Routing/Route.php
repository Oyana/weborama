<?php

namespace Weborama\Routing;

class Route
{
    public $url;
    public $pattern;
    public $methods;

    public function __construct($url, $pattern, $methods)
    {
        $this->url = $url;
        $this->pattern = $pattern;
        $this->methods = $methods;
    }

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

    private function executePatternClosure()
    {
        $closure = $this->pattern;
        return $closure();
    }

    private function executePatternController($parsedPattern)
    {
        $controllerName = CONTROLLERS_NAMESPACE . $parsedPattern[0];
        $controller = (new $controllerName);
        return $controller->{$parsedPattern[1]}(...$this->parametersValues($controller, $parsedPattern[1]));
    }

    private function parametersValues($class, $method)
    {
        $values = [];
        foreach ($this->reflectMethodParameters($class, $method) as $parameter) {
            $values[] = request()->data($parameter->name);
        }
        return $values;
    }

    private function reflectMethodParameters($class, $method)
    {
        return (new \ReflectionMethod($class, $method))->getParameters();
    }
}
