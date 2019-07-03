importScripts('https://www.gstatic.com/firebasejs/3.6.8/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/3.6.8/firebase-messaging.js');

firebase.initializeApp({
    messagingSenderId: '17465665194'    
});

const messaging = firebase.messaging();

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
