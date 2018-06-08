<?php

namespace Weborama\Request;

use Weborama\Helpers\Objects\Singletons;
use Weborama\Request\DataCollector;

class Request extends Singletons
{
    public $httpMethod = 'GET';
    public $post = [];
    public $get = [];

    protected function __construct()
    {
        $this->httpMethod = $_SERVER['REQUEST_METHOD'];
        $this->setDatas();
    }

    public function data($name)
    {
        if (isset($this->post[$name])) {
            return $this->post[$name];
        }

        if (isset($this->get[$name])) {
            return $this->get[$name];
        }

        return null;
    }

    public function setDatas()
    {
        $this->post = $_POST;
        $this->get = $_GET;
    }
}
