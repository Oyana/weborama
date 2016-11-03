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
//init $_SERVER variable to prevent very rare undefined case...
$_SERVER;
//get current route name by parsing current request with SITE_URL
if(isset($_SERVER['HTTPS'])){
	$http = 'https://';
}else {
	$http = 'http://';
}
$current_route = str_replace(SITE_URL, '', $http . $_SERVER["HTTP_HOST"] . strtok($_SERVER["REQUEST_URI"],'?'));

//display error or 404 if the route is not defined
if(isset($routes[$current_route])){

	//initiate variable
	$controller = explode('@',$routes[$current_route])[0];
	$controllerName = ucfirst($controller);
	$method = explode('@',$routes[$current_route])[1];

	//handle resource & autoload
	include(ROOT_PATH . '/models/Model.php');
	include(ROOT_PATH . '/controllers/Controller.php');
	spl_autoload_register(function ($class) {
		$classParts = explode("\\", $class);
		$classLength = count($classParts);
		$className = $classParts[$classLength - 1];

		$namespace = 'controllers';
		if(strpos($class, 'Controller') == false){
			$namespace = 'models';
		}

		for ($i = 1; $i < $classLength - 1; $i++) {
			$namespace .= '/' . $classParts[$i];
		}

		if ( file_exists(ROOT_PATH . '/' . $namespace . '/' . $className . '.php') ) {
			include ROOT_PATH . '/' . $namespace . '/' . $className . '.php';
		}
	});
	$controllerName = new $controllerName;

	//handle POST & GET request
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$method = 'post' . ucfirst($method);
	}

	//load & unset potential redirected datas
	if(isset($_SESSION['redirect'])){
		$datas = $_SESSION['redirect'];
		unset($_SESSION['redirect']);
		$controllerName->$method($datas);
	}else {
		$controllerName->$method();
	}

}else {

	if(DEBUG_LVL > 0){

		debug("No route found on $current_route");

	}else{

		include('views/errors/404.php');

	}

}
