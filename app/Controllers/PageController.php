<?php

namespace App\Controllers;

use Weborama\Controllers\Controller;

class PageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function home()
    {
        $this->view('home');
    }
}
