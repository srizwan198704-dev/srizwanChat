const cacheName = 'chat-v1';
const assets = [
  './',
  './index.html',
  'https://fonts.maateen.me/solaiman-lipi/font.css',
  'https://fonts.googleapis.com/icon?family=Material+Icons'
];

self.addEventListener('install', e => {
  e.waitUntil(
    caches.open(cacheName).then(cache => {
      cache.addAll(assets);
    })
  );
});

self.addEventListener('fetch', e => {
  e.respondWith(
    caches.match(e.request).then(res => {
      return res || fetch(e.request);
    })
  );
});
