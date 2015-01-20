<?php


namespace Error\Handler;

use Exception;

interface HandlerInterface {


    public function handle();

    public function setException(Exception $exception);

}