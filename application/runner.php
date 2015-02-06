<?php

//voeg hier command's toe aan je runner
require_once(path('library') . "function.dd.php");

Autoloader::directories(array("SampleCommand", path('application') . "commands/Sample/"));


//Error handler voor je runner
$run = new Error\Run;

//Pak je console handler
$handler = new Error\Handler\ConsoleHandler;
$run->pushHandler($handler);

$run->register();

\Weare\Console\Application::add(new SampleCommand());