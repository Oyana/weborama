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
            $this->executePatternClosure();
        }

        //check if @ notation is used
        $parsedPattern = explode('@', $this->pattern);
        if (count($parsedPattern) == 2) {
            $this->executePatternController($parsedPattern);
        }
    }

    private function executePatternClosure()
    {
        ($this->pattern)();
        app()->close();
    }

    private function executePatternController($parsedPattern)
    {
        $controllerName = CONTROLLERS_PATH . $parsedPattern[0];
        $controller = (new $controllerName);
        var_dump($controller);
        die;
        app()->close();
    }
}
