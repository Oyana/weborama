<?php
/**
 * AdminController
 *
 * @package 7agagner
 * @subpackage controllers
 */

class AdminController extends Controller
{
	public function __construct(){
		parent::__construct();
	}

	public function home(){
		if(!isset($_SESSION['user'])){
			return redirect('auth/login');
		}else {
			return $this->view('admin/home');
		}
	}
}
