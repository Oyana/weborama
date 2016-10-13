<?php

/*
|-------------------------------------------------------
| DISPLAY HELPERS & HANDLER
|-------------------------------------------------------
|
| Add some helpers function for views handling
|
*/

function view($view_name){

	include(dirname(__FILE__) . '/../../views/' . $view_name . '.php');
	return true;

}
