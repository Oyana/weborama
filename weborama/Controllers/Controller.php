<?php

namespace Weborama\Controllers;

use Weborama\Display\Displayer;

class Controller
{

    public function __construct()
    {
    }

    //add the view to the displayer
    public function view($path, $datas = [])
    {
        Displayer::view($path, $datas);
    }
}
