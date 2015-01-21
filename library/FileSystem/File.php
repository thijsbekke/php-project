<?php

namespace FileSystem;


class File
{


    /**
     * Verplaats een bestand van een locatie naar een andere locatie
     * @param $source
     * @param $destination
     * @return bool
     */
    public static function move($source, $destination)
    {
        if (!file_exists($source)) {
            return false;
        }

        if (!is_writable(dirname($destination))) {
            return false;
        }

        if (rename($source, $destination)) {
            return true;
        } else {
            return false;
        }

    }


    /**
     * Bestaat het bestand
     * @example if(File::exists("/etc/passwd")) { }
     * @param $file
     * @return bool
     */
    public static function exists($file)
    {
        return file_exists($file);
    }

    /**
     * Is het een bestand
     * @param $file
     * @return bool
     */
    public static function is($file)
    {
        return self::exists($file);
    }

    /**
     * Wat is de extensie van dit bestand
     * @param $file
     * @return mixed
     */
    public static function extension($file)
    {
        return pathinfo($file, PATHINFO_EXTENSION);
    }

    /**
     * Wat is de filename van dit bestand
     * @param $file
     * @return mixed
     */
    public static function filename($file)
    {
        return pathinfo($file, PATHINFO_FILENAME);
    }

    /**
     * Lees de inhoud van dit bestand en geef dit terug
     * @param $file
     * @return string
     */
    public static function get($file)
    {
        if (!self::exists($file)) {
            return "";
        }
        if (!self::is($file)) {
            return "";
        }
        return file_get_contents($file);

    }

    /**
     * Touch it
     * @param $file
     * @return bool
     */
    public static function touch($file)
    {
        return touch($file);
    }

    /**
     * Schrijf een bestand met inhoud weg
     * @param $file
     * @param $contents
     * @return bool|int
     */
    public static function put($file, $contents)
    {
        //Is het geen directory
        if (Dir::is($file)) {
            return false;
        }

        if (self::exists($file) && !is_writable($file)) {
            //Hebben we rechten om dit bestand te schrijven
            return false;
        }
        //Misschien is de map niet writeable
        if (!is_writable(self::parent($file))) {
            return false;
        }

        if (empty($contents)) {
            return false;
        }

        $return = file_put_contents($file, $contents);

        self::makeWriteable($file);

        return $return;
    }

    /**
     * Bestaat het bestand in het doel al ?
     * @param $file
     * @param $destination
     * @param int $count
     * @return string
     */
    public static function autoRename($file, $destination, $count = 0)
    {
        if ($count > 100) {
            //Dan ben je ook gek wanneer je dat doet
            return false;
        }
        if (!File::exists(Dir::formatPath($destination) . self::filename($file) . ($count != 0 ? " (" . $count . ")" : "") . "." . self::extension($file))) {
            return self::filename($file) . ($count != 0 ? " (" . $count . ")" : "") . "." . self::extension($file);
        }
        $count = $count + 1;
        return self::autoRename($file, Dir::formatPath($destination), $count);
    }

    /**
     * Verwijder het bestand
     * @param $file
     * @return bool
     */
    public static function remove($file)
    {
        if (!is_file($file)) {
            return false;
        }
        return unlink($file);
    }

    /**
     * Kopieer een bestand van de ene locatie naar de andere locatie
     * @param $source
     * @param $destination
     * @return bool
     */
    public static function copy($source, $destination)
    {
        if (!file_exists($source)) {
            return false;
        }

        if (!is_writable(dirname($destination))) {
            return false;
        }

        if (copy($source, $destination)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Chmod een bestand
     * @param $file
     */
    public static function makeWriteable($file)
    {
        wchmod($file, 0777);
    }

    /**
     * Wat is de groote van een bestand in bytes
     * @param $file
     * @return int
     */
    public static function size($file)
    {
        if (File::exists($file)) {
            return filesize($file);
        }
        return 0;
    }

    /**
     * In welke map zit dit bestand
     * @param $file
     * @return mixed
     */
    public static function parent($file)
    {
        return pathinfo($file, PATHINFO_DIRNAME);
    }

    /**
     * Return de contents van een file
     * @param $file
     * @return bool|string
     */
    public static function getContents($file)
    {
        return (static::exists($file) ? file_get_contents($file) : false);
    }

    /**
     * Wanneer is die voor het laatst gewijzigd
     * @param $file
     * @return bool|\DateTime
     */
    public static function modified($file)
    {
        if (!static::exists($file)) {
            return false;
        }
        return new \DateTime('@' . filemtime($file));
    }
}