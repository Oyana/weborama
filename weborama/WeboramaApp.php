<?php

namespace Weborama;

use Weborama\Routing\Router;
use Weborama\Display\Displayer;

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
        $result = (new Router)->run();
        Displayer::endResultView($result);
        Displayer::render();
    }

    //close the app
    public function close()
    {
        die;
    }

    public static function loadHelpers()
    {
        require('Helpers/helpers.php');
    }

    public static function loadRoutes()
    {
        require(ROOT_PATH . '/routes.php');
    }
}
