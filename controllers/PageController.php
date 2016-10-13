<?php
/**
 * PageController
 *
 * @package 7agagner
 * @subpackage controllers
 */

require_once('Controller.php');

class PageController extends Controller
{
	public function __contruct(){
		parent::construct();
	}

	public function home(){
		return view('home');
	}
}
