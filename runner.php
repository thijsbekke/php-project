#!/usr/bin/env php
<?php

require_once(__DIR__ . '/paths.php');

require_once(path('base') . '/env.php');


$app = \Weare\Console\Application::start();

$status = $app->run();

//$app->shutdown();

exit($status);
