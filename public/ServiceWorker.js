const filesToCache = [
    './offlineMode/offline.html',
    './offlineMode/soon.gif'
];
const staticCacheName = 'pages-cache-v1-normal';

self.addEventListener('install', event => {
    console.log('Attempting to install service worker and cache static assets');
    self.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    );
});


self.addEventListener('activate', event => {
    console.log('Service worker activating...');
    event.waitUntil(
        caches.keys().then((keyList) => {
            return Promise.all(keyList.map((key) => {
                if (key !== staticCacheName) {
                    console.log('[ServiceWorker] Removing old cache', key);
                    return caches.delete(key);
                }
            }));
        })
    );
});


self.addEventListener('fetch', event => {
        event.respondWith(
            caches.match(event.request)
                .then(response => {
                    // if (response) {
                    //     console.log('Found ', event.request.url, ' in cache');
                    //     return response;
                    // }
                    return fetch(event.request)
                }).catch(error => {
                    console.log(error);
                    if(event.request.mode == 'navigate') {
                        return caches.match('./offlineMode/offline.html');
                    }
            })
        );

});

