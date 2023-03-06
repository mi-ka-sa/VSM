<?php 

declare(strict_types = 1);

return [
    ['GET', '/', ['App\Handlers\Homepage', 'show']],
    ['GET', '/anime/catalog', ['App\Handlers\Anime', 'catalogShow']],
    ['GET', '/manga/catalog', ['App\Handlers\Manga', 'catalogShow']],
    ['GET', '/anime/{slug}', ['App\Handlers\Anime', 'show']],
    ['GET', '/manga/{slug}', ['App\Handlers\Manga', 'show']],
    ['POST', '/score/add', ['App\Handlers\Anime', 'addScore']],
    ['POST', '/score/delete', ['App\Handlers\Anime', 'deleteScore']],
    ['GET', '/user', ['App\Handlers\User', 'show']],
    ['POST', '/user/login', ['App\Handlers\User', 'login']],
    ['POST', '/user/singup', ['App\Handlers\User', 'singup']],
    ['GET', '/user/logout', ['App\Handlers\User', 'logout']],
    ['POST', '/wishlist/{action}', ['App\Handlers\Wishlist', 'main']],
    ['POST', '/review/add', ['App\Handlers\Review', 'add']],
];