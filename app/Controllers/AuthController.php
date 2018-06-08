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
        if ($user = User::getByUsername($username) && $user->password == md5($password)) {
            $this->notify('success', 'Successfully authentified.');
            $this->redirect('auth/account');
        }
        $this->notify('error', 'Email or password invalid.');
        $this->redirect('auth/login');
    }

    public function registerPage()
    {
        return $this->view('auth/register');
    }

    public function register()
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

}
