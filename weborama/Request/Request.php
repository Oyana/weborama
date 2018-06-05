<?php

namespace Weborama\Request;

class Request
{
    private function __construct()
    {
    }

    /**
     *Get an instance of the singleton
     *@return self
     */
    public static function instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new self();
        }
        return $inst;
    }

    public function httpMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
