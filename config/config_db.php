<?php

// array keys with ':' for DI
return [
    ':dsn' => 'mysql:host=localhost;dbname=anime_list',
    ':username' => 'root',
    ':password' => 'root',
    ':options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
];
