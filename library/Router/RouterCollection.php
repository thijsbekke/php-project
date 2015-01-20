<?php

namespace Router;

class RouterCollection
{

    private static $routes = array();
    private static $methods = array('GET');

    private static $settings = array();

    private static $patterns = array(
        '(:num)' => '([0-9]+)',
        '(:any)' => '([a-zA-Z0-9\.\-_%]+)',
        '(:all)' => '(.*)',
    );

    public static function route($method, $url)
    {
        //Dit is een match op basis van regex:/
        if(!is_null(($route = static::match($method, $url))))
        {
            return $route;
        }

        //Wanneer er niks is dan Event 404 uitvoeren
        Event::execute(404);
    }

    /**
     * niet case sensitive
     * @return [type] [description]
     */
    public static function caseless()
    {
        static::$settings["caseless"] = true;
    }

    /**
     * Return de waarde van een setting, bijvoorbeeld caseless
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public static function setting($key)
    {
        if(isset(static::$settings[$key]))
        {
            return static::$settings[$key];
        }
        return false;
    }

    /**
     * Match een geregistreerde route aan een url
     * @param  [type] $method [description]
     * @param  [type] $url    [description]
     * @return [type]         [description]
     */
    protected static function match($method, $url)
    {
        foreach(static::method($method) as $route => $action) {

            $pattern = '#^'.static::wildcards($route).'$#';
            if(preg_match($pattern . (static::setting('caseless') ? 'i' :''), $url, $output)) {

                return new Route($method, $route, $action, array_slice($output, 1));
            }
        }

        return null;
    }

    public static function method($method)
    {
        $routes = static::routes();

        if(isset($routes[$method]))
        {
            return $routes[$method];
        }
        return array();
    }

    protected static function wildcards($key)
    {
        return strtr($key, static::$patterns);
    }

    public static function register($method, $route, $action)
    {
        //Wanneer $method een array is jezelf weer aanroepen
        if(is_array($method))
        {
            foreach($method as $value) {
                static::register($value, $route, $action);
            }
            return;
        }

        $routes =& static::$routes;

        //Loopen door de $route heen, wanneer het een geen array is dan loopt hij maar 1 keer
        foreach((array) $route as $url)
        {

            //Wanneer het een sterretje is dan 
            if($method == '*')
            {
                foreach (static::$methods as $method)
                {
                    static::register($method, $route, $action);
                }
                return;
            }

            //Wanneer het geen method is die we ondersteunen dan return;
            if(!in_array($method, static::$methods)) return;

            if($url == '')
            {
                $url = '/';
            }

            $routes[$method][$route] = static::action($action);
        }
    }

    protected static function action($action)
    {

        if(is_string($action))
        {
            //Het is een controller aanroep
            return array('controller' => $action);
        }

        if($action instanceof \Closure)
        {
            return array($action);
        }

        return (array) $action;

    }

    public static function routes()
    {
        $routes = static::$routes;
        //Return alle routes
        foreach(array_values((array) static::$methods) as $method) {
            if(!isset($routes[$method])) $routes[$method] = array();
        }
        return $routes;
    }


}