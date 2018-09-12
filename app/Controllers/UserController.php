<?php

namespace App\Controllers;

use Weborama\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function profile(User $user, $theme = 'default')
    {
        var_dump($user);
        die;
    }
}
