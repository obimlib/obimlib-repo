// Обработчик события прихода сообщения в браузер в случае когда пользователь ходит по страницам сайта
if ('Notification' in window) {
    var messaging = firebase.messaging();
    
    messaging.onMessage(function(payload) {
        
        console.log('Message received. ', payload); 
        
        // Уведомление с учетом мобильной версии
        Notification.requestPermission(function(result) {
            if (result==='granted') {
                navigator.serviceWorker.ready.then(function(registration) {
                    
                    // Параметры уведомления - сохраняем здесь, чтобы можно было обработать затем click по уведомлению
                    payload.notification.data = payload.notification; 
                    
                    // Здесь мы показываем уведомление (если все отработало хорошо)
                    return registration.showNotification(payload.notification.title, payload.notification);
                    
                }).catch(function(error) {
                    
                    console.log('ServiceWorker registartion failed', error);
                });
            }
        });
    });
}

// Обработка клика по-уведомлению в ServiceWorker-е        
// Перенести в файл messaging-sw.js
self.addEventListener('notificationclick', function(event) {
   
    const target = event.notification.data.click_action || '/';
    event.notification.close();
    
    // Этот код должен проверять список открытых вкладок и переключаться на открытую вкладку 
    //    со ссылкой если такая есть - иначе открывать новую вкладку
    event.waitUntil(clients.matchAll({
        type: 'window',
        includeUncontrolled: true
        
    }).then(function(clientList) {

        // clientList почему-то всегда пуст
        for (var i=0; i<clientList.length; i++) {
            
            var client = clientList[i];
            if (client.url == target && 'focus' in client) {
                return client.focus();
            }
        }
        
        return clients.openWindow(target);
    }));
});


// firebase_subscribe.js - зедсь ставим свой id
firebase.initializeApp({
    messagingSenderId: '<SENDER_ID>'
});




// Браузер поддерживает уведомления - вообще, эту проверку должна делать 
//    библиотека Firebase, но она этого не делает 
if ('Notification' in window) {
    
    var messaging = firebase.messaging();
    
    // Пользователь уже разрешил получение уведомлений, подписываем на уведомления если 
    //    еще не подписали
    if (Notification.permission === 'granted') {
        subscribe();
    }
    
    $('#subscribe').on('click', function () {
        subscribe();
    });
}    
    
function subscribe() {

    // Запрашиваем разрешение на получение уведомлений
    messaging.requestPermission()
        .then(function () {

            // Получаем ID устройства
            messaging.getToken()
                .then(function (currentToken) {

                    console.log(currentToken);

                    if (currentToken) {

                        sendTokenSentToServer(false);

                    } else {

                        console.warn('Не удалось получить токен');
                        setTokenSentToServer(false);
                    }
                })
                .catch(function (err) {
                    console.warn('При получении токена произошла ошибка.', err); 
                });
    })
    .catch(function (err) {

        console.warn('Не удалось получить разрешение на показ уведомлений.', err);
    });
}

// Отправка ID на сервер
function sendTokenToServer(currentToken) {
    
    if (!isTokenSentToServer(currentToken)) {
        console.log('Отправка токена на сервер...');

        // Адрес скрипта на сервере который сохраняет ID устройства
        var url = '';
        $.post(url, {
            token: currentToken
        });
        
        setTokenSentToServer(currentToken);
        
    } else {
        
        console.log('Токен уже отправлен на сервер');
    }
}

// Используем localStorage для отметки того, что пользователь уже подписался на уведомления
function isTokenSentToServer() {    
    return window.localStorage.getItem('sentFirebaseMessagingToken') === currentToken;
}

function setTokenSentToServer(currentToken) {
    window.localStorage.setItem(
        'sentFirebaseMessagingToken',
        currentToken ? currentToken: ''
    );
}













































