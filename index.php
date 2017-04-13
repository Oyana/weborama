<?php
include('config.php');

session_name(APP_NAME);
session_start();

require_once('routes.php');

/*
|-------------------------------------------------------
| AUTOLOADER
|-------------------------------------------------------
|
| Autoload Framework function in /framework/ directory
| depending on some configuration (DEBUG_LVL, DB_TYPE, etc).
| Note that only the index.php file of each folder is loaded.
|
*/

//load these files first
require_once __DIR__ . '/framework/debugging/Debug.php';
require_once __DIR__ . '/framework/helpers/Helpers.php';

//load other folders
$files = glob(__DIR__ . '/framework/*/*.php');

//remove routing from autoload (to call it last)
if(($key = array_search(__DIR__ . '/framework/routing/Routing.php', $files)) !== false) {
    unset($files[$key]);
}

//autoload
foreach($files as $file){
	require_once $file;
}

//launch routing
require_once __DIR__ . '/framework/routing/Routing.php';
