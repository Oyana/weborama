<?php

namespace Weborama\Display;

class Displayer
{
    public static $views = [];

    public function __construct()
    {
    }

    public static function viewJson($data)
    {
        if (is_array($data)) {
            $data = json_encode($data);
        }
        self::view(null, $data);
    }

    public static function endResultView($data)
    {
        if (count(self::$views) === 0 && null !== $data) {
            self::viewJson($data);
        }
    }

    public static function view($path, $datas)
    {
        self::$views[] = new View($path, $datas);
    }

    public static function render()
    {
        foreach (self::$views as $view) {
            $view->render();
        }
    }
}
