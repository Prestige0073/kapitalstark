self.addEventListener('push', function (e) {
    var data = {};
    try { data = e.data.json(); } catch (_) { data = { title: 'KapitalStark', body: e.data ? e.data.text() : '' }; }

    e.waitUntil(
        self.registration.showNotification(data.title || 'KapitalStark', {
            body:    data.body  || '',
            icon:    data.icon  || '/favicon.ico',
            badge:   '/favicon.ico',
            data:    { url: data.url || '/' },
            vibrate: [200, 100, 200],
        })
    );
});

self.addEventListener('notificationclick', function (e) {
    e.notification.close();
    var url = (e.notification.data && e.notification.data.url) ? e.notification.data.url : '/';
    e.waitUntil(clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (list) {
        for (var i = 0; i < list.length; i++) {
            if (list[i].url === url && 'focus' in list[i]) return list[i].focus();
        }
        if (clients.openWindow) return clients.openWindow(url);
    }));
});
