<?php 

declare(strict_types = 1);

$injector = new \Auryn\Injector;

$injector->share('Symfony\Component\HttpFoundation\Request');
$injector->define('Symfony\Component\HttpFoundation\Request', [
    ':query' => $_GET,
    ':request' => $_POST,
    ':attributes' => [],
    ':cookies' => $_COOKIE,
    ':files' => $_FILES,
    ':server' => $_SERVER,
]);

$injector->share('Symfony\Component\HttpFoundation\Response');

$injector->alias('App\Template\Renderer', 'App\Template\AppSmartyRenderer');


return $injector;