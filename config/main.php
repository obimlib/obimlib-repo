<?php

// Файл с конфигурацией БД
$routes = require_once __DIR__ . '/routes.php';

$config = [
    'routes' => $routes,
    'tokens_file_path' => '/files/tokens_storage.json'
];

return $config;
