<?php

namespace Router;

class Event
{

    private static $events = array();

    public static function listen($event, $action)
    {
        static::$events[$event] = $action;
    }

    public static function listeners($event)
    {
        return isset(static::$events[$event]);
    }

    public static function execute($event, $parameters = array())
    {
        if (isset(static::$events[$event])) {
            return call_user_func(static::$events[$event], $parameters);
        } else {
            throw new Exception("Error Processing Request");
        }
    }
}