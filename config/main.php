<?php

// Файл с конфигурацией БД
$routes = require_once __DIR__ . '/routes.php';

$config = [
    'routes' => $routes
];

return $config;
