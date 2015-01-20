<?php

namespace Error\Handler;

class JsonHandler extends Handler
{
    public function handle()
    {

        $exception = $this->exception;

        $response = array(
            'type'    => get_class($exception),
            'message' => $exception->getMessage(),
            'file'    => $exception->getFile(),
            'line'    => $exception->getLine()
        );

        if(php_sapi_name() != 'cli' && !headers_sent()) {
            header('Content-Type: application/json');
        }


        echo json_encode($response);

        return Handler::QUIT;
    }
}