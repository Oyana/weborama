<?php
/**
 * PageController
 *
 * @package 7agagner
 * @subpackage controllers
 */

class PageController extends Controller
{
	public function __construct(){
		parent::__construct();
	}

	public function home(){
		debug('plop',$this,['one','two','three']);
		return view('home');
	}
}
