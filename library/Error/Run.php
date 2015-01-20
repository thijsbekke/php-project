<?php


namespace Error;

use Error\Handler\Handler;
use InvalidArgumentException;
use Exception;
use ErrorException;


class Run
{
    private $writeOutput = true;
    private $handlerStack = array();
    private $isRegistered = false;
    private $sentHttpStatusCode = 500;

    public function writeOutput($bool = null)
    {
        if (is_null($bool)) {
            return $this->writeOutput;
        }
        return $this->writeOutput = (bool)$bool;
    }

    public function sentHttpStatusCode($code = null)
    {
        if (is_null($code)) {
            return $this->sentHttpStatusCode;
        }
        return $this->sentHttpStatusCode = (int)$code;
    }

    public function pushHandler(Handler $handler)
    {

        if (!$handler instanceof Handler) {
            throw new InvalidArgumentException(
                'Argument to ' . __METHOD__ . ' must be a callable, or instance of Error\\Handler\\Handler'
            );
        }

        $this->handlerStack[] = $handler;

        return $this;
    }

    public function popHandler()
    {
        return array_pop($this->handlerStack);
    }

    public function getHandlers()
    {
        return $this->handlerStack;
    }

    public function clearHandlers()
    {
        $this->handlerStack = array();
        return $this;
    }

    public function register()
    {
        if (!$this->isRegistered) {
            set_error_handler(array($this, "handleError"));
            set_exception_handler(array($this, "handleException"));
            register_shutdown_function(array($this, "handleShutdown"));

            $this->isRegistered = true;
        }

        return $this;
    }

    public function unregister()
    {
        if ($this->isRegistered) {
            restore_exception_handler();
            restore_error_handler();

            $this->isRegistered = false;
        }

        return $this;
    }

    public function handleError($level, $message, $file = null, $line = null)
    {
        if ($level & error_reporting()) {
            $this->handleException(
                new ErrorException ($message, $level, 0, $file, $line)
            );
        }

    }

    public function handleShutdown()
    {
        if (!$this->isRegistered) return false;

        if ($error = error_get_last()) {
            $this->handleError(
                $error['type'],
                $error['message'],
                $error['file'],
                $error['line']
            );
        }
    }

    public function handleException($exception)
    {
        if (!$exception instanceof Exception) {
            throw new InvalidArgumentException(
                'Argument to ' . __METHOD__ . ' must be a callable, or instance of\\Exception'
            );
        }

        $this->sentHeaders();

        if (empty($this->handlerStack)) {
            return;
        }

        ob_start();

        foreach ($this->handlerStack as $handler) {

            $handler->setException($exception);
            $handlerResponse = $handler->handle();

            if ($handlerResponse == Handler::QUIT) {
                break;
            }
        }

        $output = ob_get_clean();

        if ($this->writeOutput()) {

            if ($handlerResponse == Handler::QUIT) {

                //Alleen mijn eigen sjit
                while (ob_get_level() > 0) ob_end_clean();
            }

            echo $output;
        }

        if ($handlerResponse == Handler::QUIT) {
            exit(1);
        }

        return $output;
    }

    protected function sentHeaders()
    {

        if (($code = $this->sentHttpStatusCode()) && php_sapi_name() != 'cli' && !headers_sent()) {

            if (function_exists('http_response_code')) {

                http_response_code($code);

            } else {
                $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

                header($protocol . ' ' . $code . ' Error');

            }
        }

        return $this;
    }
}
