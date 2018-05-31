<?php
/**
 * PageController
 *
 * @package 7agagner
 * @subpackage controllers
 */

class PageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function home()
    {
        return $this->view('home');
    }
}
