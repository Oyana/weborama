<?php
function exceptionErrorHandler($errno, $errstr, $errfile, $errline)
{
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}
set_error_handler("exceptionErrorHandler");

try {
    include('config.php');
} catch (ErrorException $ex) {
    echo "Unable to load weborama configuration file. <br />";
    echo "Please check <a href='https://github.com/Oyana/weborama/wiki/Installation'> weborama installation wiki</a>. <br />";
}

try {
    session_name(APP_NAME);
    session_start();
} catch (ErrorException $ex) {
    echo "Unable to start session. <br />";
    echo "Please check your php configuration.";
}

try {
    require_once('routes.php');
} catch (ErrorException $ex) {
    echo "Unable to load weborama routes file. <br />";
    echo "Please check <a href='https://github.com/Oyana/weborama/wiki/Routing'> weborama routes wiki</a>. <br />";
}

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
if (($key = array_search(__DIR__ . '/framework/routing/Routing.php', $files)) !== false) {
    unset($files[$key]);
}

//autoload
foreach ($files as $file) {
    require_once $file;
}

//launch routing
require_once __DIR__ . '/framework/routing/Routing.php';
