<?php

/*
|-------------------------------------------------------
| Routes
|-------------------------------------------------------
|
| Matching a bunch of URL to their controller method.
| Using Laravel data formating to find the right
| controller to call for the routing action
|
*/

$routes = [

	//auth routes
	"/auth/login"=>"UserController@login",
	"/auth/register"=>"UserController@register",
	"/auth/logout"=>"UserController@logout",
	"/auth/account"=>"UserController@account",

	//basic pages routes
	"/"=>"PageController@home",
];
