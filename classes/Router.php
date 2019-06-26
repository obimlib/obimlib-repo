<?php

namespace Push_Message;

/**
 * Класс предназначен для выполнения маршрутизации получаемых запросов
 *
 * @author Oleg Pyatin o.pyatin@bimlib.pro
 */
class Router
{
    // Функция разрешения полученного маршрута
    public static function resolveQuery(?string $url, ?array $config):?array
    {
        // Выполнение разбора
        $fields = parse_url($url);

        // Делаем разбивание с помощью регулярного выражения
        preg_match_all("/\/[a-zA-Z0-9_]+/", $fields['path'], $matches);

        // Устранение слэшей в начале
        for ($i=0; $i<count($matches[0]); $i++) {
            $matches[0][$i] = substr($matches[0][$i], 1);
        }

        // Запуск прохода по маршрутам
        try {
            $types = static::checkRoute($matches[0], $config['routes']['paths']);
        } catch (Exception $exc) {
            throw new RequestException(REQUEST_RESOLVE_ERROR);
        }

        return $types;
    }

    // Функция для сравнения пришедшего запроса и имеющихся маршрутов
    public static function checkRoute(array $parts, array $routes):?array
    {
        $types = null;

        foreach ($routes as $key=>$value) {

            // Разбор роута
            preg_match_all("/\/[a-zA-Z0-9{}_]+/", $key, $route_parts);
            for ($i=0; $i<count($route_parts[0]); $i++) {
                $route_parts[0][$i] = substr($route_parts[0][$i], 1);
            }

            // Выполняем сравнение по регулярным выражениям
            $equal = true;
            // Сравниваем равенство маршрута
            for ($i=0; $i<count($route_parts[0])-1; $i++) {

                if (strcasecmp($route_parts[0][$i], $parts[$i])) {
                    $equal = false;
                }
            }

            $buf_parts = $route_parts[0];

            if ($equal) {

                $check_number = false;

                if (isset($buf_parts[count($buf_parts)-1])) {

                    $check_number = (bool)preg_match('/{\w+}/', $buf_parts[count($buf_parts)-1]);
                }

                if ($check_number && is_numeric((int)$parts[count($parts)-1])) {

                    $types = $value;
                    $types += [
                        'quant' => ((int)$parts[count($parts)-1]) ?? null
                    ];

                } elseif (!strcasecmp($buf_parts[count($buf_parts)-1], $parts[count($parts)-1])) {

                    $types = $value;
                    $types += [
                        'quant' => null
                    ];

                }
            }
        }

        return $types;
    }
}
