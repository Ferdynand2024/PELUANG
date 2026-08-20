self.addEventListener('install', (event) => {
    console.log('Service Worker terpasang.');
});

self.addEventListener('fetch', (event) => {
    // Biarkan request berjalan normal secara online
    event.respondWith(fetch(event.request));
});