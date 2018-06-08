<?php

namespace App\Controllers;

use Weborama\Controllers\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function loginPage()
    {
        $this->view('auth/login');
    }

    public function login($username, $password)
    {
    }

    public function registerPage()
    {
        return $this->view('auth/register');
    }

    public function register()
    {
    }

    public function logout()
    {
    }
}
