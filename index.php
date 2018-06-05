<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

require __DIR__.'/config.php';
require __DIR__.'/weborama/Autoloader.php';

//run the autoloader to gather all needed classes
$autoloader = new Weborama\Autoloader;

$autoloader->register();

$autoloader->addNamespace('App', ROOT_PATH . '/app/');
$autoloader->addNamespace('Weborama', ROOT_PATH . '/weborama/');

//get the main application instance
$weborama = Weborama\WeboramaApp::instance();

// Ask the framework to run itself up
// This will dispatch the request,
// call the right route and
// wrap things up
$weborama->run();
