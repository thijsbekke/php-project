<?php

namespace Router;
/**
 * Class Route
 * @package Router
 */
class Route
{

    private $method = "";
    private $route = "";
    private $action = "";
    private $parameters = "";

    /**
     * Construct
     * @param $method
     * @param $route
     * @param $action
     * @param array $parameters
     */
    public function __construct($method, $route, $action, $parameters = array())
    {
        $this->method = $method;
        $this->route = $route;
        $this->action = $action;
        $this->parameters = $parameters;
    }

    /**
     * Voer een routering uit, eerst filter before, dan de routering zelf en daarna het filter after
     * @return mixed|static
     */
    public function call()
    {
        $response = Filter::run($this->getFilter('before'), array());

        if (is_null($response)) {
            //Het kan zijn dat we een response hebben van de before actie, dan hoeven we de echte actie niet uit te voeren
            $response = $this->response();
        }
        $response = Response::prepare($response);

        Filter::run($this->getFilter('after'), array($response));

        return $response;
    }

    public function getFilter($filter)
    {

        if (isset($this->action[$filter])) {
            return $this->action[$filter];
        }
        return null;
    }

    /**
     * Voer een actie uit en return de response
     * @return mixed
     */
    protected function response()
    {
        return $this->action[0]($this->parameters);
    }

    /**
     * Registreer een get route
     * @param $route
     * @param $action
     */
    public static function get($route, $action)
    {
        RouterCollection::register('GET', $route, $action);
    }

    /**
     * Registreer een post route
     * @param $route
     * @param $action
     */
    public static function post($route, $action)
    {
        RouterCollection::register('POST', $route, $action);
    }

    /**
     * Registreer een filter
     * @param $filter
     * @param $action
     */
    public static function filter($filter, $action)
    {
        Filter::register($filter, $action);
    }

    /**
     * Registreer routes aan de hand van een controller
     * @param $route
     * @param IController $controller
     */
    public static function controller($route, IController $controller)
    {

        foreach ($controller->methods($route) as $function) {
            $method = $function->method;
            Route::$method($function->route, $function->action());
        }

    }

}