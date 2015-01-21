<?php


namespace Weare\Console;

/**
 * Class Application
 * @package Weare\Console
 */
class Application
{
    public static function start()
    {

        $path = path("application") . "runner.php";

        if(file_exists($path))
        {
            //De runner/global application file wordt ingeladen
            include_once($path);
        }

        return new Application();
    }

    public function run()
    {
        global $argv;

        $argv = $_SERVER['argv'];

        //Todo:: verdere implementatie maken dat er daadwerkelijk application/runner/methods in worden geladen die je kan uitvoeren


    }


}