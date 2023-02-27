<?php

function debug($data, $die = false)
{
    echo '<pre>' . print_r($data, 1) . '</pre>';
    if ($die) {
        die;
    }
}

function redirect ($http = false) 
{
    if ($http) {
        $redirect = $http;
    } else {
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    }
    header("Location: {$redirect}");
    die;
}

function base_url()
{
    return PATH . '/';
}

function get_inf_of_class($obj)
{
    $reflect = new \ReflectionClass($obj);
    debug($reflect->getMethods());
    debug($reflect->getProperties());
    die;
}

function h($str)
{
    return htmlspecialchars($str);
}


