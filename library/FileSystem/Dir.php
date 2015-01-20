<?php

namespace FileSystem;

class Dir
{

    /**
     * Bestaat een map daadwerkelijk
     * @param $dir
     * @return bool
     */
    public static function exists($dir)
    {
        return is_dir($dir);
    }

    /**
     * Synoniem voor Dir::exists()
     * @param $dir
     * @return bool
     */
    public static function is($dir)
    {
        return self::exists($dir);
    }

    /**
     * Maak een map en maak deze schrijfbaar
     * @param $dir
     */
    public static function make($dir)
    {
        if (!self::exists($dir)) {
            mkdir($dir, 0777, true);
            self::makeWriteable($dir);
        }

    }

    /**
     * Maak een map schrijfbaar
     * @param $dir
     */
    public static function makeWriteable($dir)
    {
        chmod($dir, 0777);
    }

    /**
     * Verwijder een map met al zijn inhoud
     * @param $dir
     * @return bool
     */
    public static function delete($dir)
    {
        if (is_dir($dir)) {
            $files = array_diff(scandir($dir), array('.', '..'));
            foreach ($files as $file) {
                (is_dir($dir . "/" . $file)) ? self::delete($dir . "/" . $file) : unlink($dir . "/" . $file);
            }
            return rmdir($dir);
        }
        return false;
    }

    /**
     * Krijg een array met alle mappen en bestanden van een map
     * @param $dir
     * @return array
     */
    public static function getList($dir)
    {
        $fileArray = array();
        if (!self::exists($dir)) {
            return $fileArray;
        }
        if ($handle = opendir($dir)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $fileArray[] = $entry;
                }
            }
            closedir($handle);
        }
        return $fileArray;
    }

    /**
     * Kopieer de map met inhoud van locatie 1 naar locatie 2
     * @param $src
     * @param $destination
     */
    public static function copy($src, $destination)
    {
        Dir::make($destination);
        Dir::makeWriteable($destination);

        if (is_dir($src)) {
            $dir = opendir($src);
            while (false !== ($file = readdir($dir))) {
                if (($file != '.') && ($file != '..')) {
                    if (is_dir($src . '/' . $file)) {
                        self::copy($src . '/' . $file, $destination . '/' . $file);
                    } else {
                        copy($src . '/' . $file, $destination . '/' . $file);
                    }
                }
            }
            closedir($dir);
        }
    }

    /**
     * Zorg voor een slash aan het einde van het pad
     *
     * @param $path string
     *
     * @return string (Path inclusief slash)
     */
    public static function formatPath($path)
    {
        return (substr($path, -1) === "/" ? $path : $path . "/");
    }

    /**
     * Verplaats een map van locatie 1 naar locatie 2
     * @param $source
     * @param $destination
     * @return bool
     */
    public static function move($source, $destination)
    {
        if (!is_dir($source)) {
            return false;
        }

        if (!is_writable(dirname($destination))) {
            return false;
        }

        //Wanneer de destination niet leeg is dan mag het niet,
        if (is_dir($destination)) {
            return false;
        }

        if (rename($source, $destination)) {
            return true;
        } else {
            return false;
        }

    }
}