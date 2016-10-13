<?php
/*
|-------------------------------------------------------
| Handle Routes
|-------------------------------------------------------
|
| Parse the current URL to find which route to call.
| This is the main routing function, instantiating
| automatically the required controller and call it.
|
*/

//get current route name by parsing current request with SITE_URL
$current_route = str_replace(SITE_URL, '', $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);

//display error or 404 if the route is not defined
if(isset($routes[$current_route])){

	//initiate variable
	$controller = explode('@',$routes[$current_route])[0];
	$controllerName = ucfirst($controller);
	$method = explode('@',$routes[$current_route])[1];

	//handle resource
	require_once(dirname(__FILE__) . '/../../controllers/' . $controller . '.php');
	$controllerName = new $controller;
	$controllerName->$method();

}else {

	if(DEBUG_LVL > 0){

		debug("Aucune route n'est définie sur $current_route");

	}else{

		include('views/errors/404.php');

	}

}
