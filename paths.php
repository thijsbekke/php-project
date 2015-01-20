<?php

/*
Paths.php
 */

chdir(__DIR__);

define("DS", DIRECTORY_SEPARATOR);

set_path("base", getcwd() . DS);
set_path("library", getcwd() . DS . "library" . DS);
set_path("storage", getcwd() . DS . "storage" . DS);
set_path("application", getcwd() . DS . "application" . DS);

/**
 * Een pad uit je globals halen en returnen
 * @param $path
 * @return string
 */
function path($path) {
    if(isset($GLOBALS["env_paths"][$path])) {
        return $GLOBALS["env_paths"][$path];
    }
    return "";
}

/**
 * Een pad opnemen in je global
 * @param $path
 * @param $value
 */
function set_path($path, $value) {
    $GLOBALS["env_paths"][$path] = $value;
}