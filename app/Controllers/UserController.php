<?php

namespace App\Controllers;

use Weborama\Controllers\Controller;

class UserController extends Controller
{
    public function account(User $user)
    {
        var_dump($user);
        die;
    }
}
