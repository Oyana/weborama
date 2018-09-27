<?php

namespace Weborama;

use Weborama\Routing\Router;
use Weborama\Display\Displayer;
use Weborama\Messages\Messager;
use Weborama\Helpers\Objects\Singletons;

final class WeboramaApp extends Singletons
{
    //run the app
    public function run()
    {
        session_start();
        Messager::loadSessionMessages();
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
        include 'Helpers/helpers.php';
    }

    public static function loadRoutes()
    {
        include ROOT_PATH . '/routes.php';
    }

    public function messages($type)
    {
        return Messager::render($type);
    }
}
