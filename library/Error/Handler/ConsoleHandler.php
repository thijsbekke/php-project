<?php

namespace Error\Handler;

use Exception;

class ConsoleHandler extends Handler
{


    public function __construct()
    {

    }

    public function handle()
    {
        echo "Console-Error-Handler: " . $this->exception->getMessage() . PHP_EOL;
        print_r($this->exception);

        return Handler::QUIT;
    }
}