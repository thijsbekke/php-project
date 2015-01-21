<?php

namespace Error\Handler;

use Exception;

abstract class Handler implements HandlerInterface
{

    /** Done */
    const DONE = 0x10;
    /** Laatste handler */
    const LAST_HANDLER = 0x20;
    /** Afsluiten */
    const QUIT = 0x30;

    protected $exception = null;

    /**
     * Set de exceptie die we moeten gaan verwerken
     * @param Exception $exception
     */
    public function setException(Exception $exception)
    {
        $this->exception = $exception;
    }
}