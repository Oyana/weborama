<?php

namespace App\Controllers;

use Weborama\Controllers\Controller as Controller;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        $this->view('auth/login');
    }

    public function postLogin()
    {
        $datas = $_POST;
        $user = new User();
        if (!$user->validate($datas)) {
            $this->setError('Email or password invalid.');
            return $this->login();
        } elseif (sizeof($user->getByWhere([ 'email'=> $datas['email'], 'password' => md5($datas['password']) ])) == 1) {
            $_SESSION['user'] = $datas['email'];
            $this->setSuccess('Connected to your account');
            return redirect('auth/account');
        } else {
            $this->setError('Email or password unknown.');
            return $this->login();
        }
    }

    public function register()
    {
        return $this->view('auth/register');
    }

    public function postRegister()
    {
        $datas = $_POST;
        $user = new User();
        $validation = $user->validate($datas);
        if ($validation) {
            if ($datas['password'] == $datas['validatepassword']) {
                if (sizeof($user->getByWhere(['email'=>$datas['email']])) == 0) {
                    $user->addByarray(['email'=>$datas['email'],'pseudo'=>$datas['email'],'password'=>md5($datas['password'])]);
                    $this->setSuccess('Account created');
                    $_SESSION['user'] = $datas['email'];
                    return redirect('auth/account');
                } else {
                    $this->setSuccess('This email is aldready in use');
                    return $this->register();
                }
            } else {
                $this->setError($validation);
                return $this->register();
            }
        } else {
            $this->setError($validation);
            return $this->register();
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);
        $this->setInfo('Logout succesfully');
        return redirect('');
    }

    public function account()
    {
        if (!isset($_SESSION['user'])) {
            redirect('auth/login');
        } else {
            redirect('auth/account');
        }
    }
}
