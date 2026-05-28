// Jenin Care Service Worker - PWA
const CACHE_NAME = 'jenincare-v2';
const STATIC_CACHE = 'jenincare-static-v2';
const DYNAMIC_CACHE = 'jenincare-dynamic-v2';

// Files to cache immediately (only files that definitely exist)
const STATIC_ASSETS = [
    '/',
    '/manifest.json',
    '/css/tailwind.css',
    '/css/main.css',
    '/js/app.js',
    '/favicon.ico',
];

// Cache static assets gracefully (skip missing files)
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(STATIC_CACHE).then((cache) => {
            return Promise.allSettled(
                STATIC_ASSETS.map(url =>
                    cache.add(url).catch(err => console.log('Skip cache:', url, err.message))
                )
            );
        }).then(() => self.skipWaiting())
    );
});

// Activate - clean old caches
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((names) => {
            return Promise.all(
                names.filter(n => n !== STATIC_CACHE && n !== DYNAMIC_CACHE)
                     .map(n => caches.delete(n))
            );
        }).then(() => self.clients.claim())
    );
});

// Fetch - network first for pages, cache first for assets
self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);
    if (request.method !== 'GET') return;
    if (url.origin !== self.location.origin) return;

    // API: network only
    if (url.pathname.startsWith('/api/')) return;

    // Static assets: cache first
    if (/\.(css|js|png|jpg|jpeg|gif|webp|svg|ico|woff2?|ttf)$/.test(url.pathname)) {
        event.respondWith(
            caches.match(request).then(cached => cached || fetch(request).then(res => {
                if (res.ok) {
                    const clone = res.clone();
                    caches.open(STATIC_CACHE).then(c => c.put(request, clone));
                }
                return res;
            }))
        );
        return;
    }

    // Pages: network first, fallback to cache
    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request).then(res => {
                if (res.ok) {
                    const clone = res.clone();
                    caches.open(DYNAMIC_CACHE).then(c => c.put(request, clone));
                }
                return res;
            }).catch(() => caches.match(request).then(cached => cached || caches.match('/')))
        );
    }
});

// Push notifications
self.addEventListener('push', (event) => {
    if (!event.data) return;
    const data = event.data.json();
    event.waitUntil(
        self.registration.showNotification(data.title || 'Jenin Care', {
            body: data.body || '',
            icon: '/favicon.ico',
            badge: '/favicon.ico',
            vibrate: [100, 50, 100],
            data: { url: data.url || '/' }
        })
    );
});

self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    event.waitUntil(clients.openWindow(event.notification.data.url || '/'));
});

self.addEventListener('message', (event) => {
    if (event.data && event.data.type === 'SKIP_WAITING') self.skipWaiting();
});
