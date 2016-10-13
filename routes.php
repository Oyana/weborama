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
	"/"=>"PageController@home",
	"/contact"=>"PageController@contact"
];
