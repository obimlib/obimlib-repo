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

                if ($_GET['type'] === 'push-send' && isset($_POST['title'])) {
    //            if ($query['query_type'] === SEND_PAGE) {
                    $tokens = FileLinker::getListTokens($config['tokens_file_path']);
                    static::sendPushMessage($tokens, [
                        'title'=>$_POST['title'],
                        'content'=>$_POST['content']
                    ]);
                    echo "Сообщение было отправлено";
                    // Продумать сохранение токена
                }

                if ($_GET['type'] === 'save') {
    //            if ($query['query_type'] === SEND_PAGE) {
//                    FileLinker::loadTokensFile('/files/tokens_storage.json');
                    FileLinker::addNewToken($_GET['token'], $config['tokens_file_path']);
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
    public static function sendPushMessage($list_tokens, $message_options)
    {
        $message_data = [
            'title'=>$message_options['title'],
            'content'=>$message_options['content']
        ];

        $url = 'https://fcm.googleapis.com/fcm/send';
        $api_key = 'AAAABBEI5qo:APA91bFGUcnVfVEAq3EMjMWxcDikpIX12r8jX-lazn90Yyv1bLPCblggbARbExoqsPhRdiNtLHD9wCvEQyvxzy8oIOkKtzCVfjujm-p664QfyeXot-rHRXAgC6A7CJYUbJgEOFZptfdY';

        $request_body = [
//            'to'=>'e8dLmON_JTU:APA91bEwVmNVSNOc5jSPoa8MIFP_7GXWRKT-IaYKCiFKqi2hIO4ehdzBxh6Fu4iktxgZ4v8X6Brt9u40Qo27PL1Ntr9H6Z9uP7OUFL4XOr4pW7UXVWOyuQgVvj31nGiY_kXVdeN3nUz0',
            'registration_ids'=>$list_tokens,
            'notification'=>[
                'title'=>$message_data['title'],
                'body'=>$message_data['content'],
                'click_action'=>'https://bimlib.pro'
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
        curl_setopt($channel, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($channel, CURLOPT_SSL_VERIFYHOST,0);

        $response = curl_exec($channel);
        curl_close($channel);
    }

}
