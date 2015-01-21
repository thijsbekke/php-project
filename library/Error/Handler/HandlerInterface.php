<?php

namespace Error\Handler;

use Exception;

/**
 * Interface HandlerInterface
 * @package Error\Handler
 */
interface HandlerInterface
{

    /**
     * @return mixed
     */
    public function handle();

    /**
     * @param Exception $exception
     * @return mixed
     */
    public function setException(Exception $exception);

}