<?php

namespace Push_Message;

/**
 * Класс Viewer предназначен для вывода итоговой информации
 *
 * @author Oleg Pyatin o.pyatin@bimlib.pro
 */
class Viewer
{
    // Функция стандартного рендеринга представлений (Вывод HTTP-ответа из потока)
    public static function render(string $file, array $params):void
    {
        extract($params, EXTR_SKIP);
        ob_start();

        try {
            
            include ROOT_PATH.$file;

        } catch (\Throwable $exc) {

            ob_end_clean();
            throw $exc;
        }

        $response = ob_get_clean();
        echo $response;
    }

    /**
     * Функция отправки итогового Json-Response ответа
     *
     * @param mixed $formatted_data JSON Данные для отсылки
     * @param bool $empty_data Отсылать пустые данные (случай ошибки)
     * @return mixed
     */
    public static function sendJsonInfo(?string $formatted_data, bool $empty_data=false):void
    {
        // Здесь установливаем заголовок json
        header('Content-Type: application/json');
        // Здесь даем возможность делать кросс-доменные запросы
        header("Access-Control-Allow-Origin: *");

        // Итоговый вывод данных
        if (!$empty_data) {
            echo $formatted_data;
        } else {
            echo null;
        }
    }
}
