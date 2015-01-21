<?php

namespace Rest;
/**
 * Class Method
 * @package Rest
 */
class Method
{

    public $method = "";
    public $route = "";
    protected $callable = null;

    public function __construct($method, $route, $callable)
    {
        $this->method = $method;
        $this->route = $route;
        $this->callable = $callable;

    }

    /**
     * Krijg een callable terug
     * @return null
     */
    public function action()
    {
        if(is_callable($this->callable)) {
            return $this->callable;
        }
        return function() {};
    }


}
