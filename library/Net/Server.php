<?php

namespace Net;

class Server
{
    public function get($key, $default = null)
    {
        if(!isset($_SERVER[strtoupper($key)])) {

            if(is_null($default)) {
                return false;
            }
            return $default;
        }
        return $_SERVER[strtoupper($key)];
    }
}