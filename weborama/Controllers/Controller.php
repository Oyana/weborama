<?php

namespace Weborama\Controllers;

use Weborama\Display\Displayer;
use Weborama\Notification\Notifier;

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

    //add a notification
    public function notify($type, $message)
    {
        Displayer::view($path, $datas);
    }
}
