<?php

/**
 * Файл с маршрутами для роутинга, по имеющимся маршрутам анализируем подходит ли входящий
 *    запрос какому нибудь из маршрутов - если да, определяем параметры запросов для него
 */

namespace Push_Message;

$routes = [
    'paths' => [
        '/note' => [
            'query_type'=>NOTE_PAGE,
        ],
        '/send' => [
            'query_type'=>SEND_PAGE,
        ],
    ]
];

return $routes;
