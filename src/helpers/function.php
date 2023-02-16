<?php

function debug($data, $die = false)
{
    echo '<pre>' . print_r($data, 1) . '</pre>';
    if ($die) {
        die;
    }
}

function get_inf_of_class($obj)
{
    $reflect = new \ReflectionClass($obj);
    debug($reflect->getMethods());
    debug($reflect->getProperties());
    die;
}
