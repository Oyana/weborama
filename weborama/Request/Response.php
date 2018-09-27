<?php

namespace Weborama\Request;

use Weborama\Helpers\Objects\Singletons;
use Weborama\Routing\Route;

class Response extends Singletons
{
    /**
     * Set the response HTTP status
     * 
     * @param int $status the HTTP response status
     * 
     * @return void
     */
    public function status($status)
    {
        http_response_code($status);
        return $this;
    }
}
