<?php

namespace Router;

/**
 * Class Response
 * @package Router
 */
class Response {
    private $content;
    protected $version;
    protected $statusCode;
    protected $statusText;
    protected $charset;

    public static $statusTexts = array(
        200 => 'OK',
        404 => 'Not Found',
        500 => 'Internal server error'
    );

    public function __construct($content, $status = 200)
    {
        $this->content = $content;

        $this->setProtocolVersion("1.0");

        $this->setStatusCode($status);
    }

    public function setProtocolVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    public function setStatusCode($code, $text = null)
    {
        $this->statusCode = (int) $code;
        $this->statusText = (is_null($text) ? static::$statusTexts[$this->statusCode] : $text);
    }

    public function render()
    {
        //Wanneer het een object is met een __tostring methode dan doen we dat
        if (is_object($this->content) and method_exists($this->content, '__toString'))
        {
            $this->content = $this->content->__toString();
        }
        else
        {
            $this->content = (string) $this->content;
        }

        return $this->content;
    }

    public function send()
    {
        $this->sendHeaders();
        $this->sendContent();

        return $this;
    }

    public function sendHeaders()
    {
        //Wanneer de headers al zijn geset dan skippen we de rest
        if (headers_sent()) {
            return $this;
        }

        // status
        header(sprintf('HTTP/%s %s %s', $this->version, $this->statusCode, $this->statusText));

        return $this;
    }

    public function sendContent()
    {
        echo $this->content;

        return $this;
    }

    public static function prepare($response)
    {
        if ( ! $response instanceof Response)
        {
            $response = new static($response);
        }

        return $response;
    }
}
