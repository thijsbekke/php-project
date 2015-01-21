<?php
namespace Content;

class View
{
    public function __construct()
    {

    }

    /**
     * @param $view
     * @return ViewObject
     */
    public static function make($view)
    {
        //Hier gaan we een view object maken, die moet een interface van view hebben, kunnen we hem niet vinden ? dan roepen we de standaard ViewObject aan

        //Het view object heeft een constructor daar geven we de $view aan mee.
        //Het view object heeft ook een toString, die wordt uitgevoerd bij het aanroepen van de response. Dus nog niet wanneer before (of een andere filter wordt uitgevoerd)

        $class = '\\' . $view;
        if (class_exists($class, true)) {
            return new $class($view);
        } else {
            return new ViewObject($view);
        }
    }

}

