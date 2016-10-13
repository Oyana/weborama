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

function debug($message){
	echo '<pre>';
	print_r($message);
	echo '</pre>';
	die();
}
