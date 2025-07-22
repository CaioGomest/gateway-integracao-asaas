const CACHE_NAME = 'JustPay-cache-v1';
const urlsToCache = [
  '/',
  '/index.html',
  'https://i.imgur.com/Xe0jrt4.png',
  // Adicione aqui outros recursos que você deseja cachear, como CSS, JS, imagens, etc.
];

// Instala o Service Worker e cacheia os recursos
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => {
        console.log('Cache aberto');
        return cache.addAll(urlsToCache);
      })
  );
});

// Intercepta as requisições de rede e responde com os recursos em cache, se disponíveis
self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request)
      .then((response) => {
        // Se o recurso estiver no cache, retorna do cache
        if (response) {
          return response;
        }
        // Caso contrário, busca na rede
        return fetch(event.request);
      }
    )
  );
});

// Atualiza o cache e remove caches antigos
self.addEventListener('activate', (event) => {
  const cacheWhitelist = [CACHE_NAME];
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cacheName) => {
          if (cacheWhitelist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});
