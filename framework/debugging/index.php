<?php

/*
|-------------------------------------------------------
| DEBUG HELPERS & HANDLER
|-------------------------------------------------------
|
| Display the debugging information to the page
| with helpers function or when errors are returned
|
*/


error_reporting(0);
switch(DEBUG_LVL){
	case 0:
		error_reporting(0);
	break;
	case 1:
		error_reporting(E_ALL);
		ini_set('display_errors',true);
	break;
	case 2:
		error_reporting(E_ALL);
		ini_set('display_errors',true);
	break;
	default:
		error_reporting(E_ALL);
		ini_set('display_errors',true);
	break;
}

function debug($message){
	if(DEBUG_LVL > 0){
	echo '<pre>';
	print_r($message);
	echo '</pre>';
	die();
	}else {
		return true;
	}
}
