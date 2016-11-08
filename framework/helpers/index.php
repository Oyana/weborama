<?php

function asset($url){
	return SITE_URL . '/public/' . $url;
}

function stored($url){
	return SITE_URL . '/storage/' . $url;
}

function route($routename){
	return SITE_URL . '/' . $routename;
}

function redirect($routename, $savedDatas = array()) {
	if(!empty($savedDatas)){
		$_SESSION['redirect'] = $savedDatas;
	}
	header('location:'.SITE_URL . '/' . $routename);
}
