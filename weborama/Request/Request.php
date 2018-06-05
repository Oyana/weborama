<?php

namespace Weborama\Request;

use Weborama\Helpers\Objects\Singletons;

class Request extends Singletons
{
    public function httpMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
