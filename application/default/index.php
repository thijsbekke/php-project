<?php
session_start();

//Hier gaan we alles includen wat we eigenlijk standaard willen includen, 
include_once('../../paths.php');

//Je current pad definieren
set_path('app', path('application') . 'default' . DS);



//Environment variabelen laden
include_once(path('base') . 'env.php');

//Global settings laden
include_once(path('application') . 'global.php');

Autoloader::directories(array(
    path('app') . "controllers" . DS
));



include_once(path('app') . 'routes.php');


//Niet case sensitive
\Router\RouterCollection::caseless();

//Krijg een route van de current request, deze zijn aangegeven in routes.php

/** @var \Router\Route $route */
$route = \Router\RouterCollection::route(\Net\Request::method(), \Net\Request::current());
/** @var \Router\Response $response */

$response = $route->call();

//Hier gaan we hem renderen
$response->render();


//Deze functie zorgt ervoor dat de headers worden geset, en hier komt daadwerkelijk de echo te staan
$response->send();


