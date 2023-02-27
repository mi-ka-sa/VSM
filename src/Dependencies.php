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

$injector->define('App\Page\FilePageReader', [
    ':pageFolder' => ROOT . '/pages',
]);

$injector->alias('App\Page\PageReader', 'App\Page\FilePageReader');
$injector->share('App\Page\FilePageReader');

$injector->share('PDO');
$injector->define('PDO', require_once CONFIG . '/config_db.php');

// $injector->share('App\Handlers\Anime');

return $injector;