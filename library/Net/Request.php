<?php

namespace Net;

class Request
{

    protected static $uri;
    protected static $segments;
    protected static $base;
    protected static $server;


    public static function method()
    {
        return static::server()->get('REQUEST_METHOD');
    }

    public static function pathInfo()
    {

        if(($pathinfo = static::server()->get('PATH_INFO', '')) == '')
        {

            return '/';
        }
        return $pathinfo;
    }

    public static function current()
    {
        if(!is_null(static::$uri)) return static::$uri;

        $uri = static::pathInfo();

        static::segments($uri);

        return static::$uri = $uri;
    }

    /**
     * Haal de segmenten van / tot / op van een uri
     * @param $uri
     */
    protected static function segments($uri)
    {
        if(!($pathinfo = static::server()->get('PATH_INFO'))) { static::$segments = array();  return; }

        $parts = explode ('/', strtolower(trim($pathinfo, '/')));
        static::$segments = array_diff($parts, array(''));
    }

    /**
     * Haal een specifiek segment van / tot / op uit een url
     * @param $index
     * @param array $segments
     * @return null
     */
    public static function segment($index, $segments = array())
    {
        if(empty($segments)) static::current() and $segments = static::$segments;

        if(isset($segments[$index])) return $segments[$index];

        return null;
    }

    protected static function server()
    {
        if(is_null(static::$server))
        {
            static::$server = new Server();
        }
        return static::$server;
    }

    /**
     * Wat is de host van de server ?
     * @return mixed
     */
    public static function host()
    {
        if (!$host = static::server()->get("HTTP_HOST")) {
            if (!$host = static::server()->get("HTTP_HOST")) {
                $host = static::server()->get('SERVER_ADDR', '');
            }
        }
        return $host;
    }

    /**
     * Is het HTTPS of HTTP
     * @return string
     */
    public static function scheme()
    {
        return ((static::server()->get('HTTPS') && static::server()->get('HTTPS') != "off") ? "https" : "http");
    }

    /**
     * Welke poort draaien we op
     * @return mixed
     */
    public static function port()
    {
        return $_SERVER["SERVER_PORT"];
    }

    public static function httpHost()
    {
        $scheme = static::scheme();
        $port   = static::port();

        if (('http' == $scheme && $port == 80) || ('https' == $scheme && $port == 443)) {
            return static::host();
        }

        return static::host().':'.$port;
    }

    protected static function calculateBasePath()
    {
        $scriptName = static::server()->get('SCRIPT_NAME');
        //Strip de index.php eraf
        return substr($scriptName, 0, strrpos($scriptName, '/')) . '/';
    }

    public static function basePath()
    {
        if (static::$base === null) {
            static::$base = static::calculateBasePath();
        }
        return static::$base;
    }

    public static function rootUrl()
    {
        return static::scheme().'://'.static::httpHost().static::basePath();
    }

}