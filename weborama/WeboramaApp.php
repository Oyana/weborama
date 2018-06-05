<?php

namespace Weborama;

use Weborama\Request\Request;
use Weborama\Routing\Router;

final class WeboramaApp
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

    //run the app
    public function run()
    {
        $this->loadHelpers();
        $this->loadRoutes();
        (new Router)->run();
    }

    //close the app
    public function close()
    {
        die;
    }

    private function loadHelpers()
    {
        require('Helpers/helpers.php');
    }

    private function loadRoutes()
    {
        require(ROOT_PATH . '/routes.php');
    }
}
