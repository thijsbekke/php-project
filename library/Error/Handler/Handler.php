<?php

namespace Error\Handler;

use Exception;

abstract class Handler implements HandlerInterface
{

    const DONE = 0x10;
    const LAST_HANDLER = 0x20;
    const QUIT = 0x30;

    protected  $exception = null;

    public function setException(Exception $exception)
    {
        $this->exception = $exception;
    }
}