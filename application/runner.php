<?php

//voeg hier command's toe aan je runner
require_once(path('library') . "function.dd.php");

//Error handler voor je runner
$run = new Error\Run;

//Pak je console handler
$handler = new Error\Handler\ConsoleHandler;
$run->pushHandler($handler);

$run->register();