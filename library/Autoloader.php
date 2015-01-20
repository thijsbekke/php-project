<?php

class Autoloader
{

    protected static $namespaceArray = array();
    protected static $dirArray = array();
    protected static $aliasArray = array();
    protected static $mapArray = array();

    public static function load($class)
    {
        //Laad de class die word gevraagd 
        if (isset(static::$aliasArray[$class]))
        {
            return class_alias(static::$aliasArray[$class], $class, true);
        }
        elseif (isset(static::$mapArray[$class]))
        {
            return require(static::$mapArray[$class]);
        }

        //Namespace inladen
        foreach (static::$namespaceArray as $namespace => $directory)
        {
            if (strpos($class, $namespace) === 0)
            {
                return static::load_psr(substr($class, strlen($namespace)), $directory);
            }
        }

        static::load_psr($class);
    }

    protected static function load_psr($class, $directory = null)
    {
        // The PSR-0 standard indicates that class namespaces and underscores
        // should be used to indicate the directory tree in which the class
        // resides, so we'll convert them to slashes.
        $file = str_replace(array('\\', '_'), '/', $class);

        $directories = $directory ?: static::$dirArray;

        foreach ((array) $directories as $directory)
        {
            if (file_exists($path = $directory.$file.'.php'))
            {
                return require $path;
            }
        }
    }

    public static function namespaces($namespaces)
    {
        //Geeft aan waar welke namespace leeft
        foreach((array) $namespaces as $namespace => $directory)
        {
            static::$namespaceArray[$namespace] = static::format($directory);
        }
    }

    public static function directories($directories)
    {
        if(!is_array($directories))
        {
            return;
        }
        //Is niet nodig want we programmeren goed :-D
        $directories = static::format($directories);
        static::$dirArray = array_unique(array_merge(static::$dirArray, $directories));
    }

    public static function alias($aliasses)
    {
        foreach((array) $aliasses as $class => $alias)
        {
            static::$aliasArray[$alias] = $class;
        }
    }

    protected static function format($directories)
    {
        return array_map(function($directory)
        {
            return rtrim($directory, DS).DS;

        }, (array) $directories);
    }

    public static function map($mapping)
    {
        static::$mapArray = array_merge(static::$mapArray, (array) $mapping);
    }
}