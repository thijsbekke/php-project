<?php

function dbaObject($object, $arg)
{
    if(empty($arg))
    {
        return $object;
    }
    return $object->$arg;
}

function dbaArray($array, $arg)
{

    $return = array();
    foreach($array as $key => $value)
    {

        if(is_object($value))
        {
            $return[$key] = dbaObject($value, $arg);
        }
        elseif(is_array($value))
        {
            $return[$key] = (isset($value[$arg]) ? $value[$arg] : $value);
        }
        else
        {
            $return[$key] = $value;
        }
    }
    return $return;
}

function dba($object, $arg = '')
{
    $return = $object;

    if(is_object($object))
    {
        $return = dbaObject($object, $arg);

    }
    elseif(is_array($object) && isset($object[$arg]))
    {
        $return = $object[$arg];

    }
    elseif(is_array($object) && count($object) > 1)
    {
        $return = dbaArray($object, $arg);
    }

    echo highlight_string("<?php \n" . var_export($return, true) . "\n?>", true);
}

function dd($object, $arg = '')
{
    $trace = debug_backtrace();
    dba($trace[0]);
    dba($object, $arg);
    die();
}

function pp($object)
{
    echo "<li>" . print_r($object, 1) . "</li>";
}

