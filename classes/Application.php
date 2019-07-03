<?php

namespace Push_Message;

class Application
{
    // Функция маршрута по веб-приложению
    public static function run(array $config):void
    {
        try {

            try {

//                $query = Router::resolveQuery($_SERVER['REQUEST_URI'], $config);

  //              if ($query['query_type'] === NOTE_PAGE) {
                if ($_GET['type'] === 'note') {
                    Viewer::render('views/note_page.php', []);
                }
                if ($_GET['type'] === 'send') {
    //            if ($query['query_type'] === SEND_PAGE) {
                    Viewer::render('views/user_page.php', []);
                }

                if ($_GET['type'] === 'push-send') {
    //            if ($query['query_type'] === SEND_PAGE) {
                    static::sendPushMessage();
                    echo "Message send";

                    // Продумать сохранение токена
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

    // Пишут что нужно запускать через консоль (если не пойдет - проверить)
    public static function sendPushMessage() {

        $url = 'https://fcm.googleapis.com/fcm/send';
        $api_key = 'AAAABBEI5qo:APA91bFGUcnVfVEAq3EMjMWxcDikpIX12r8jX-lazn90Yyv1bLPCblggbARbExoqsPhRdiNtLHD9wCvEQyvxzy8oIOkKtzCVfjujm-p664QfyeXot-rHRXAgC6A7CJYUbJgEOFZptfdY';
        $token_id = '17465665194';

        // Пока отсылки на mail и пр

        $request_body = [
            //'to'=>$token_id,
            // Пока делаем в одиночном варианте - через to
            'to'=>'',
            'notification'=>[
                'title'=>'Уведомление',
                'body'=>sprintf('Начало в %s', date('H:i')),
//                'icon'=>'https://',
                'click_action'=>'http://mail.ru'
            ]
        ];

        $fields = json_encode($request_body);

        $request_headers = [
            'Content-type: application/json',
            'Authorization: key=' . $api_key
        ];

        $channel = curl_init();
        curl_setopt($channel, CURLOPT_URL, $url);
        curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($channel, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($channel, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($channel, CURLOPT_FOLLOWLOCATION, true);
        $repsonse = curl_exec($channel);
        curl_close();

        echo '<pre>';
        print_r($response);
        echo '</pre>';
        exit();
        // Потом проверить отработку cURL
    }

}
