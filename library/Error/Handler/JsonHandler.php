<?php

namespace Error\Handler;
/**
 * Class JsonHandler
 * @package Error\Handler
 */
class JsonHandler extends Handler
{
    /**
     * @return int
     */
    public function handle()
    {
        $exception = $this->exception;

        //Reponse array
        $response = [
            'type'    => get_class($exception),
            'message' => $exception->getMessage(),
            'file'    => $exception->getFile(),
            'line'    => $exception->getLine()
        ];

        if(php_sapi_name() != 'cli' && !headers_sent()) {
            header('Content-Type: application/json');
        }

        echo json_encode($response);

        //En we zijn klaar met het afhandelen
        return Handler::QUIT;
    }
}