<?php


require_once(path('library') . "function.dd.php");

//Overrulen we de auto load functie, ies sneller
//Autoloader::map(array("Auth", path('library') . "class.Auth.php"));
//Autoloader::map(array("Template", path('library') . "Template.php"));
//Autoloader::map(array("Translate", path('library') . "class.Translate.php"));


$run = new Error\Run;


//$handler = new Error\Handler\JsonHandler;
//$run->pushHandler($handler);

//$handler = new Error\Handler\ConsoleHandler();
//$run->pushHandler($handler);

//Handle errors based on events
//$handler = new Error\Handler\EventHandler();
//$run->pushHandler($handler);

$handler = new Error\Handler\PrettyPageHandler;
$run->pushHandler($handler);

$run->register();
