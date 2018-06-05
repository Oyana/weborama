<?php

namespace App\Controllers;

use Weborama\Controllers\Controller as Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function home()
    {
        if (!isset($_SESSION['user'])) {
            return redirect('auth/login');
        } else {
            $this->view('admin/home');
        }
    }
}
