<?php

namespace Router;

class Filter {

    private static $filters = array();

    public function __construct()
    {


    }

    public static function register($filter, $action)
    {
        static::$filters[$filter] = $action;
    }

    public static function run($filter, $parameter) {
        if(isset(static::$filters[$filter])) {
            $method = static::$filters;
            return $method[$filter]($parameter);
        }
    }
}