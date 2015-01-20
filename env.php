<?php

ob_start();

/*
Laat alle errors zien
 */
error_reporting(-1);

//Maak van je app path je root.
if(path('app') != '') {
    chdir(path('app'));
}

require_once(path('library') . "Autoloader.php");

Autoloader::directories(array(
    path('library'),
    path('library') . "Adapter" . DS,
    path('library') . "Object" . DS
));

Autoloader::namespaces(array(
    'filesystem'    => path('library')
));

spl_autoload_register(array('Autoloader', 'load'));

