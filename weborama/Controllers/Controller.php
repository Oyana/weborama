<?php

namespace Weborama\Controllers;

use Weborama\Display\Displayer;
use Weborama\Messages\Messager;

class Controller
{
    //add the view to the displayer
    public function view($path, $datas = [])
    {
        Displayer::view($path, $datas);
    }

    //add a notification
    public function notify($type, $message)
    {
        Displayer::view($path, $datas);
    }

    public function message($type, $data)
    {
        Messager::add($type, $data);
    }
}
