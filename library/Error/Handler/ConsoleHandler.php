<?php

namespace Error\Handler;

/**
 * Class ConsoleHandler
 * Handler om errors weer te geven in formaat wat te lezen is in een CLI omgeving
 * @package Error\Handler
 */
class ConsoleHandler extends Handler
{

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Geef de error weer
     * @return int
     */
    public function handle()
    {
        echo "Console-Error-Handler: " . $this->exception->getMessage() . PHP_EOL;
        print_r($this->exception);

        return Handler::QUIT;
    }
}