<?php

namespace App\Controllers;

use Weborama\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = (new User)->all();
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
        $user = (new User)->hydrate(request()->post)->persist();

        $this->message('success', 'User ' . $user->name . ' successfully created');

        redirect($user->id . '/profile');
    }
    
    public function editForm(User $user)
    {
        $this->view('users/edit', compact('user'));
    }
    
    public function editUser(User $user)
    {
        $user = $user->hydrate(request()->post)->persist();

        $this->message('success', 'User ' . $user->name . ' successfully edited');
        
        redirect($user->id . '/profile');
    }
    
    public function delete(User $user)
    {
        $user->delete();

        $this->message('success', 'User ' . $user->name . ' successfully deleted');
        
        redirect('profiles');
    }    
}
