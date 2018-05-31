<?php

require __DIR__.'/config.php';
require __DIR__.'/weborama/Autoloader.php';

//run the autoloader to gather all needed classes
$autoloader = new Weborama\Autoloader;

$autoloader->register();

$autoloader->addNamespace('Weborama', ROOT_PATH . '/weborama/');

//get the main application instance
$weborama = new Weborama\WeboramaApp();

//ask the framework to handle the request
$weborama->handleRequest();
