<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Вход в систему</title>
        <meta charset="utf-8">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
            }
            body {
                background: #fcfcfc;
                font-family: "Helvetica Neue", Helvetica, Calibri, sans-serif;
                color: #020;
            }
            main, header, footer, aside, section, menu, nav, details, summary, figure, figcaption {
                display: block;
            }
            header {
                background: #00696b;
                height: 80px;
                text-align: center;
                padding: 18px;
            }
            h2 {
                color: #fff;
                font-size: 38px;
                cursor: default;
                user-select: none;
            }
            h3 {
                font-size: 32px;
                display: block;
                margin: 0 auto;
                padding: 60px 0 15px;
                user-select: none;
            }
            h3:first-of-type{
                padding-top: 10px;
            }
            main {
                position: relative;
                margin-top: 100px;
                text-align: center;
            }
            input[type="text"], input[type="password"] {
                width: 300px;
                padding: 15px;
                border: 1px solid #888;
                border-radius: 8px;
                -moz-border-radius: 8px;
                -webkit-border-radius: 8px;
                outline: none;
                font-size: 16px;
            }

            .button-block {
                position: relative;
                margin-top: 60px;
            }

            .blocks-messages {
                position: relative;
                margin: 0 auto 40px;
                width: 400px;
                font-size: 18px;
                border: 1px solid #f66;
                border-radius: 8px;
                -moz-border-radius: 8px;
                -webkit-border-radius: 8px;
                padding: 25px;
            }


            message-button {
                width: 200px;
                padding: 12px;
                font-size: 18px;
                background: #00afa1;
                color: #fff;
                transition: background 0.15s;
                text-align: center;
                border: none;
                border-radius: 6px;
                cursor: pointer;
            }
            message-button:hover {
                background: #00696b;
            }
        </style>
    </head>
    <body>
        <header>
            <div class="standart-block">
                <h2>Отправка PUSH-уведомлений</h2>
            </div>
        </header>
        <main>
            <div class="standart-block">
                <h3>Оформить подписку</h3>
                <button class="message-button">Оформить</button>
                <h3>Отправить сообщения</h3>
                <input type="text" placeholder="Текст сообщения" name="message">
                <button class="message-button">Отправить</button>
            </div>
        </main>
    </body>
</html>
