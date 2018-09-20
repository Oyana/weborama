<?php

namespace Weborama\Request;

use Weborama\Helpers\Objects\Singletons;
use Weborama\Request\DataCollector;

class Request extends Singletons
{
    public $httpMethod = 'GET';
    public $post = [];
    public $get = [];
    public static $available_methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

    protected function __construct()
    {
        $this->setDatas();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'];
        if ($this->httpMethod === 'POST' && !empty($this->post['_method'])) {
            if (in_array(strtoupper($this->post['_method']), Request::$available_methods)) {
                $this->httpMethod = strtoupper($this->post['_method']);
            } else {
                throw new \Exception("Bad http method supplied : " . $this->post['_method'] . " is not a supported http method", 1);
            }
        }
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
