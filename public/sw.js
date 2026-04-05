const CACHE_NAME = 'vibes-art-v1';
const STATIC_ASSETS = [
    '/',
    '/login',
    '/registro',
    '/manifest.json',
];

// Instalar service worker
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(STATIC_ASSETS);
        })
    );
    self.skipWaiting();
});

// Activar y limpiar caches viejos
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((name) => name !== CACHE_NAME)
                    .map((name) => caches.delete(name))
            );
        })
    );
    self.clients.claim();
});

// Interceptar peticiones - Network first, cache fallback
self.addEventListener('fetch', (event) => {
    // Solo interceptar peticiones GET
    if (event.request.method !== 'GET') return;

    // No interceptar peticiones de admin ni API
    const url = new URL(event.request.url);
    if (url.pathname.startsWith('/admin')) return;

    event.respondWith(
        fetch(event.request)
            .then((response) => {
                // Guardar en cache si es exitoso
                if (response.status === 200) {
                    const responseClone = response.clone();
                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(event.request, responseClone);
                    });
                }
                return response;
            })
            .catch(() => {
                // Si no hay red, usar cache
                return caches.match(event.request).then((cached) => {
                    if (cached) return cached;
                    // Página offline por defecto
                    return caches.match('/');
                });
            })
    );
});

// Notificaciones push
self.addEventListener('push', (event) => {
    const data = event.data ? event.data.json() : {};
    const title = data.title || '🎨 Vibes Art';
    const options = {
        body: data.body || '¿Cómo te sientes hoy?',
        icon: '/icons/icon-192x192.png',
        badge: '/icons/icon-72x72.png',
        vibrate: [100, 50, 100],
        data: { url: data.url || '/diario' },
    };
    event.waitUntil(self.registration.showNotification(title, options));
});

// Click en notificación
self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    event.waitUntil(
        clients.openWindow(event.notification.data.url || '/diario')
    );
});
