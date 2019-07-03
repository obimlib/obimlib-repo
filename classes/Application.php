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
    public static function sendPushMessage()
    {
        /*
        $query_url = 'https://bimlib.amocrm.ru/api/v2/contacts?limit_rows=500&limit_offset=3000';

        $curl = curl_init();

        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,$query_url);
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);


        $out=curl_exec($curl);
        $code=(int)curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        //$list = static::curlQuery($query_url);
        echo "<pre>";
        print_r($out);
        echo "</pre><br><br>";
        exit();*/



        $url = 'https://fcm.googleapis.com/fcm/send';
        $api_key = 'AAAABBEI5qo:APA91bFGUcnVfVEAq3EMjMWxcDikpIX12r8jX-lazn90Yyv1bLPCblggbARbExoqsPhRdiNtLHD9wCvEQyvxzy8oIOkKtzCVfjujm-p664QfyeXot-rHRXAgC6A7CJYUbJgEOFZptfdY';
        $token_id = '17465665194';

        // Пока отсылки на mail и пр

        $request_body = [
            //'to'=>$token_id,
            // Пока делаем в одиночном варианте - через to
            'to'=>'e8dLmON_JTU:APA91bEwVmNVSNOc5jSPoa8MIFP_7GXWRKT-IaYKCiFKqi2hIO4ehdzBxh6Fu4iktxgZ4v8X6Brt9u40Qo27PL1Ntr9H6Z9uP7OUFL4XOr4pW7UXVWOyuQgVvj31nGiY_kXVdeN3nUz0',
            'notification'=>[
                'title'=>'Уведомление',
                'body'=>sprintf('Начало в %s', date('H:i')),
//                'icon'=>'https://',
                'click_action'=>'https://mail.ru'
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
        curl_setopt($channel,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($channel,CURLOPT_SSL_VERIFYHOST,0);

        $response = curl_exec($channel);
        //$code = curl_getinfo($channel);
        curl_close($channel);

        //echo '<pre>';
        //print_r($code);
        //echo '</pre>';
        //exit();
        // Потом проверить отработку cURL


    }

}
