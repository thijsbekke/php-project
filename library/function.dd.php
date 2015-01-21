<?php

/**
 * Return een object in een formaat leesbaar voor mensen
 * @param $object
 * @param $arg
 * @return mixed
 */
function dbaObject($object, $arg)
{
    if(empty($arg))
    {
        return $object;
    }
    return $object->$arg;
}

/**
 * Return een array in een formaat leesbaar voor mensen
 * @param $array
 * @param $arg
 * @return array
 */
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

/**
 * Return een variabel in een formaat leesbaar voor mensen
 * @param $object
 * @param string $arg
 */
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

/**
 * Alias voor dba met een debug trace om je dd() weer op te zoeken
 * @param $object
 * @param string $arg
 */
function dd($object, $arg = '')
{
//    $trace = debug_backtrace();
//    dba($trace[0]);
    dba($object, $arg);
    die();
}

/**
 * List een variabel
 * @param $object
 */
function pp($object)
{
    echo "<li>" . print_r($object, 1) . "</li>";
}

