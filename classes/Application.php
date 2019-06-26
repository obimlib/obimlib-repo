<?php

namespace Push_Message;

class Application
{
    // Функция маршрута по веб-приложению
    public static function run(array $config):void
    {
        try {

            try {

                $query = Router::resolveQuery($_SERVER['REQUEST_URI'], $config);

                if ($query['query_type'] === NOTE_PAGE) {
                    Viewer::render('views/note_page.php', []);
                }
                if ($query['query_type'] === SEND_PAGE) {
                    Viewer::render('views/user_page.php', []);
                }

            } catch (RequestException $exc) {

                throw new CommonException($exc->getMessage());
            }

            try {

                // Код для выполнения основных операций

            } catch (ProcessException $exc) {

                throw new CommonException($exc->getMessage());
            }

            try {

                // Код для вывода данных на экран

            } catch (\Throwable $exc) {

                throw new CommonException(VIEW_ERROR_MESSAGE);
            }

        } catch (CommonException $exc) {

            // Создать различные Exception-ы и сообщения для них в bootstrap
            echo BASE_ERROR_MESSAGE;
        }
    }

}
