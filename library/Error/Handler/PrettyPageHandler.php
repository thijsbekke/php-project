<?php

namespace Error\Handler;

use Exception;

class PrettyPageHandler extends Handler
{


    public function __construct()
    {

    }

    public function handle()
    {

        echo "<h2>PrettyPage-Error-Handler: " . $this->exception->getMessage() . "</h2><pre>";
        print_r($this->exception);
        echo "</pre>";

        return Handler::QUIT;
    }


}