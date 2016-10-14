<?php
/**
 * UserController
 *
 * @package 7agagner
 * @subpackage controllers
 */

class UserController extends Controller
{
	public function __construct(){
		parent::__construct();
	}

	public function login(){
		return view('auth/login');
	}

	public function Postlogin(){
		$datas = $_POST;
		$user = new User();
		if(!$user->validate($datas)){
			$this->setError('Email or password invalid.');
			return $this->login();
		}elseif(sizeof($user->getByWhere(['email'=>'"'.$datas['email'].'"','password' => '"' . md5($datas['password']) . '"'])) == 1){
			$_SESSION['user'] = $datas['email'];
			$this->setSuccess('Connected to your account');
			return $this->account();
		}else {
			$this->setError('Email or password unknown.');
			return $this->login();
		}
	}

	public function register(){
		return view('auth/register');
	}

	public function Postregister(){
		$datas = $_POST;
		$user = new User();
		$validation = $user->validate($datas);
		if($validation){
			if($datas['password'] == $datas['validatepassword']){
				if(sizeof($user->getByWhere(['email'=>$datas['email']])) == 0){
					$user->addByarray(['email'=>$datas['email'],'password'=>md5($datas['password'])]);
					$this->setSuccess('Account created');
					$_SESSION['user'] = $datas['email'];
					return redirect('auth/account');
				}else {
					$this->setSuccess('This email is aldready in use');
					return $this->register();
				}
			}else {
				$this->setError($validation);
				return $this->register();
			}
		}else {
			$this->setError($validation);
			return $this->register();
		}
	}

	public function logout(){

	}

	public function account(){
		if(!isset($_SESSION['user'])){
			return $this->login();
		}else {
			return view('auth/account', array('email' => $_SESSION['user']));
		}
	}

}
