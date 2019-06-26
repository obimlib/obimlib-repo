<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Оформление подписки</title>
        <meta charset="utf-8">
        <style>
            .note-window {
                z-index: 10;
                width: 215px;
                height: 75px;
                background: #f7f7f7;
                border: 2px solid #ededed;
                -webkit-border-radius: 15px;
                -moz-border-radius: 15px;
                border-radius: 15px;
                overflow: hidden;
                position: fixed;
                right: 4%;
                bottom: 4%;
                box-shadow: 2px 2px 3px rgba(0,0,0,0.3);
                cursor: pointer;
                transition: background 0.2s;
                font-size: 13px;
                font-family: Calibri;
            }
            .note-window:hover {
                background: #fdfdfd;
            }
            .note-window-header {
                font-size: 14px;
                padding: 2px 11px;
            }
            .note-window-divide-line {
                height: 1px;
                border-bottom: 1px solid #ccc;
                margin: 0 auto 5px;
                width: 90%;

            }
            .note-window-content {
                padding: 0 11px;
                color: #333;
            }
            body {
                padding-top: 50px;
                background: #fcfcfc;
            }
            h2 {
                display: block;
                font-family: Arial, sans-serif;
                margin: 0 auto;
                text-align: center;
                font-size: 34px;
                color: #333;
            }

        </style>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
    </head>
    <body>
        <header>
            <div class="standart-block">
                <h2>Подписка на PUSH-уведомления</h2>
            </div>
        </header>
        <main>
            <div class="standart-block">
            </div>
        </main>
    </body>
    <script>
        function showNotificationWindow(header, message) {

            var body_elem = document.querySelector('body');

            var note_window_header = document.createElement('div');
            note_window_header .className="note-window-header";
            note_window_header .innerHTML = header;

            var note_window_divide_line = document.createElement('div');
            note_window_divide_line.className="note-window-divide-line";

            var note_window_content = document.createElement('div');
            note_window_content.className="note-window-content";
            note_window_content.innerHTML = message;

            var note_window = document.createElement('div');
            note_window.className="note-window";
            note_window.appendChild(note_window_header);
            note_window.appendChild(note_window_divide_line);
            note_window.appendChild(note_window_content);

            body_elem.appendChild(note_window);
        }
    </script>
    <script defer>

        if (Notification.permission==='granted') {

            window.addEventListener('load', function () {
                var socket = io('http://localhost:300');
                socket.on('bimlib_note', function (data) {
                    showNotificationWindow(data.header, data.message)
                });
            });

        } else {

            function requestPermission() {

                return new Promise(function (resolve, reject) {

                    const permissionResult = Notification.requestPermission(function (result) {
                        resolve(result);
                    });

                    if (permissionResult) {
                        permissionResult.then(resolve, reject);
                    }
                })
                .then(function (permissionResult) {

                    if (permissionResult==='granted') {

                        if ('serviceWorker' in navigator) {
                            window.addEventListener('load', function () {
                                navigator.serviceWorker.register('./socket.js').then(function(registration) {
                                    console.log('ServiceWorker registration successful');
                                }, function (err) {
                                    console.log('ServiceWorker registration failed: ', err);
                                });
                            });
                        } else {
                            console.log("Not service Worker in browser");
                        }

                    } else {
                        console.log('No permission get');
                    }
                });
            }

            requestPermission();
        }

    </script>
</html>