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

    public function matchedWithUrl($currentUrl)
    {
        $parsedCurrentUrl = explode('/', $currentUrl);
        foreach ($this->fillableParameters as $index => $parameter) {
            $this->filledParameters[] = $parsedCurrentUrl[$index];
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
        foreach ($this->reflectMethodParameters($class, $method) as $index => $parameter) {
            if (null !== $parameter->getType()) {
                $objectTypeHintedName = $parameter->getType()->getName();
                $values[] = new $objectTypeHintedName($this->filledParameters[$index]);
            } else {
                $values[] = $this->filledParameters[$index];
            }
        }
        return $values;
    }

    private function reflectMethodParameters($class, $method)
    {
        return (new \ReflectionMethod($class, $method))->getParameters();
    }
}
