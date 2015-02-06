<?php


namespace Weare\Console;

/**
 * Class Application
 * @package Weare\Console
 */
class Application
{

    protected static $objects = [];

    public static function start()
    {

        $path = path("application") . "runner.php";

        if (file_exists($path)) {
            //De runner/global application file wordt ingeladen
            include_once($path);
        }

        return new Application();
    }

    protected function getArguments()
    {
        $argv = (isset($_SERVER['argv']) ? $_SERVER['argv'] : []);
        array_shift($argv);
        return $argv;
    }

    public function run()
    {
        $argv = $this->getArguments();

        $command = $argv[0];

        if(isset(self::$objects[$command])) {
            self::$objects[$command]->run();
        }
        //Todo:: verdere implementatie maken dat er daadwerkelijk application/runner/methods in worden geladen die je kan uitvoeren
    }

    protected static function className($name)
    {
        return strtolower($name);
    }

    public static function add($object)
    {
        $className = self::className(get_class($object));
        if(isset(self::$objects[$className])) {
            return false;
        }
        self::$objects[$className] = $object;
        return true;
    }
}