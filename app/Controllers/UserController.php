<?php

namespace App\Controllers;

use Weborama\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $this->view('users/index', compact('users'));
    }

    public function show(User $user, $theme = 'default')
    {
        $this->view('users/show', compact('user', 'theme'));
    }
    
    public function createForm()
    {
        $this->view('users/create');
    }
    
    public function createUser()
    {
        $user = User::hydrate(request()->post)->persist();
        redirect($user->id . '/profile');
    }
    
    public function editForm(User $user)
    {
        $this->view('users/form', compact('user'));
    }
    
    public function editUser(User $user)
    {

    }
    
    public function delete(User $user)
    {

    }
    
    
    
    
    
}
