<?php

namespace Router;

class Route
{

    private $method = "";
    private $route = "";
    private $action = "";
    private $parameters = "";


    public function __construct($method, $route, $action, $parameters = array())
    {
        $this->method = $method;
        $this->route =  $route;
        $this->action = $action;
        $this->parameters = $parameters;
    }

    public function call()
    {
        $response = Filter::run($this->getFilter('before'), array());

        if(is_null($response))
        {
            //Het kan zijn dat we een response hebben van de before actie, dan hoeven we de echte actie niet uit te voeren
            $response = $this->response();
        }
        $response = Response::prepare($response);

        Filter::run($this->getFilter('after'), array($response));

        return $response;
    }

    public function getFilter($filter)
    {

        if(isset($this->action[$filter]))
        {
            return $this->action[$filter];
        }
        return null;
    }

    protected function response()
    {
        return $this->action[0]($this->parameters);
    }

    public static function get($route, $action)
    {
        RouterCollection::register('GET', $route, $action);
    }

    public static function post($route, $action)
    {
        RouterCollection::register('POST', $route, $action);
    }


    public static function filter($filter, $action)
    {
        Filter::register($filter, $action);
    }


    public static function controller($route, IController $controller)
    {

        //Bestaat die voilla we hebben hem sneller.
        Route::get($route, function($data) use ($controller) {
            //Hier voert hij alle actis uit
            return $controller->index($data);
        });

        Route::get($route . '(:num)', function($data) use ($controller) {
            //Hier voert hij alle actis uit
            return $controller->show($data);
        });

        Route::get($route . '(:num)/edit', function($data) use ($controller) {
            //Hier voert hij alle actis uit
            return $controller->edit($data);
        });

        Route::get($route . '(:num)/delete', function($data) use ($controller) {
            //Hier voert hij alle actis uit
            return $controller->delete($data);
        });


        Route::get($route . 'create', function($data) use ($controller) {
            //Hier voert hij alle actis uit
            return $controller->create($data);
        });

    }

}