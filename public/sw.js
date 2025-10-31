const CACHE_NAME = 'weather-app-shell-v1';
const DATA_CACHE = 'weather-data-cache-v1';
const ASSETS = [
  '/',
  '/css/app.css',
  '/js/app.js',
  '/offline'
];

// Installer : cache des assets
self.addEventListener('install', e => {
  e.waitUntil(
    caches.open(CACHE_NAME).then(cache => cache.addAll(ASSETS))
  );
  self.skipWaiting();
});

// Activation : purge les anciens caches
self.addEventListener('activate', e => {
  e.waitUntil(
    caches.keys().then(keys =>
      Promise.all(keys.map(key => {
        if (![CACHE_NAME, DATA_CACHE].includes(key)) {
          return caches.delete(key);
        }
      }))
    )
  );
  self.clients.claim();
});

// Interception fetch : prioritaire au cache
self.addEventListener('fetch', e => {
  if (e.request.url.includes('/api/weather')) {
    e.respondWith(
      caches.open(DATA_CACHE).then(cache =>
        fetch(e.request)
          .then(resp => {
            cache.put(e.request, resp.clone());
            return resp;
          })
          .catch(() => cache.match(e.request))
      )
    );
  } else {
    e.respondWith(
      caches.match(e.request).then(res => res || fetch(e.request))
        .catch(() => caches.match('/offline'))
    );
  }
});
