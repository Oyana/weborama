<?php

/*
|-------------------------------------------------------
| DISPLAY HELPERS & HANDLER
|-------------------------------------------------------
|
| Add some helpers function for views handling
|
*/

function view($view_name, $formatedData = array()){

	//add datas to view
	foreach($formatedData as $key => $data){
		//boom variable variable, that's how !
		${$key} = $data;
	}

	if(file_exists(ROOT_PATH . '/views/' . $view_name . '.php')){
		include(ROOT_PATH . '/views/' . $view_name . '.php');
		return true;
	}else {
		debug('No view found at ' . ROOT_PATH . '/views/' . $view_name . '.php' );
		return false;
	}

}
