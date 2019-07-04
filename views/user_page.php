<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Вход в систему</title>
        <meta charset="utf-8">
        <style>
            body {
                padding-top: 30px;
                background: #fcfcfc;
                font-family: Arial, sans-serif;
            }
            h2 {
                display: block;
                margin: 0 auto;
                text-align: center;
                font-size: 34px;
                color: #333;
            }

            .field-container {
                width: 60%;
                margin: 40px auto;
                text-align: center;
            }
            h3 {
                text-align: center;
                display: block;
                font-size: 24px;
                color: #333;
            }
            .send-message {
                padding: 12px;
                font-size: 18px;
                background: #00afa1;
                color: #fff;
                transition: background 0.15s;
                display: block;
                position: relative;
                margin: 60px auto 0;
                border-radius: 6px;
                text-align: center;
                width: 270px;
                border: 0;
                cursor: pointer;
            }
            .send-message:hover {
                background: #00696b;
            }

            .form-input-style {
                display: block;
                border: 1px solid #ebebeb;
                border-radius: 6px;
                padding: 10px;
                width: 270px;
                font-size: 15px;
                font-family: Arial, sans-serif;
                margin: 0 auto;
            }

        </style>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
    </head>
    <body>
        <header>
            <div class="standart-block">
                <h2>Получение PUSH-уведомлений</h2>
            </div>
        </header>
        <main>
            <div class="standart-block">
                <form method="POST" action="/index.php?type=push-send">
                    <div class="field-container">
                        <h3>Заголовок сообщения</h3>
                        <input type="text" placeholder="Заголовок" class="header-field form-input-style" name="title">
                    </div>
                    <div class="field-container">
                        <h3>Содержание</h3>
                        <input type="text" placeholder="Содержание" class="content-field form-input-style" name="content">
                    </div>
                    <input type="submit" value="Отослать сообщения" class="send-message">
                </form>
                <!--<button class="send-message">Отослать сообщения</button>-->
            </div>
        </main>
    </body>
</html>
