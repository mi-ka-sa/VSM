<?php 

declare(strict_types = 1);

return [
    ['GET', '/', ['App\Handlers\Homepage', 'show']],
    ['GET', '/anime/{slug}', ['App\Handlers\Anime', 'show']],
    ['GET', '/manga/{slug}', ['App\Handlers\Manga', 'show']],
    ['GET', '/user', ['App\Handlers\User', 'show']],
    ['POST', '/user/login', ['App\Handlers\User', 'login']],
    ['POST', '/user/singup', ['App\Handlers\User', 'singup']],
    ['GET', '/user/logout', ['App\Handlers\User', 'logout']],
];