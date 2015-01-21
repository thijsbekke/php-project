<?php

namespace Router;

/**
 * Registreer een event
 * Class Event
 * @package Router
 */
class Event
{

    private static $events = array();

    /**
     * Voeg listeners toe aan een event, deze worden uitgevoerd wanneer execute wordt aangeroepen
     * @param $event
     * @param $action
     */
    public static function listen($event, $action)
    {
        static::$events[$event] = $action;
    }

    /**
     * Return alle listeners
     * @param $event
     * @return bool
     */
    public static function listeners($event)
    {
        return isset(static::$events[$event]);
    }

    /**
     * Execute een event
     * @param $event
     * @param array $parameters
     * @return mixed
     * @throws Exception
     */
    public static function execute($event, $parameters = array())
    {
        if (isset(static::$events[$event])) {
            return call_user_func(static::$events[$event], $parameters);
        } else {
            throw new Exception("Error Processing Request");
        }
    }
}