<?php

namespace Router;
/**
 * Een filter wordt uitgevoerd voor of na het uitvoeren van een route
 * Class Filter
 * @package Router
 */
class Filter {

    private static $filters = array();

    public function __construct()
    {

    }

    /**
     * Registreer een filter
     * @param $filter
     * @param $action
     */
    public static function register($filter, $action)
    {
        if(is_callable($action)) {
            static::$filters[$filter] = $action;
        }
    }

    /**
     * Voer een filter uit
     * @param $filter
     * @param $parameter
     * @return mixed
     */
    public static function run($filter, $parameter) {
        if(isset(static::$filters[$filter])) {
            $method = static::$filters;
            return $method[$filter]($parameter);
        }
    }
}