importScripts('https://storage.googleapis.com/workbox-cdn/releases/5.1.2/workbox-sw.js');

const {CacheFirst, StaleWhileRevalidate, NetworkFirst, NetworkOnly} = workbox.strategies;
const {CacheableResponsePlugin} = workbox.cacheableResponse;
const {ExpirationPlugin} = workbox.expiration;
const {matchPrecache, precacheAndRoute} = workbox.precaching;
const {registerRoute, setDefaultHandler, setCatchHandler, NavigationRoute} = workbox.routing;

const VERSION = 'v1::';
const CACHE_NAME = VERSION+"static-cache";
const APP_IMAGE_CACHE = 'app-image-cache'

const PRECACHE = [
  '/offline.html',
  '/asset/css/theme.css',
  '/images/website/1.webp',
  'https://fonts.gstatic.com/s/nunito/v12/XRXW3I6Li01BKofAjsOUYevI.woff2',
  'https://kit.fontawesome.com/5c2c380e3d.js',
  'https://kit-free.fontawesome.com/releases/latest/webfonts/free-fa-brands-400.woff2',
  'https://kit-free.fontawesome.com/releases/latest/webfonts/free-fa-solid-900.woff2',
  '/asset/js/app-behavior.js',
  '/asset/js/jquery-3.5.1.min.js',

];

self.addEventListener('install', async (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(function(cache){
      cache.addAll(PRECACHE);
    })
  );
});


const networkOnly = new NetworkOnly();
const navigationHandler = async (params) => {
  try {
    // Attempt a network request.
    return await networkOnly.handle(params);
  } catch (error) {
    // If it fails, return the cached HTML.
    return caches.match(PRECACHE[0], {
      cacheName: CACHE_NAME,
    });
  }
};

// Register this strategy to handle all navigations.
registerRoute(
  new NavigationRoute(navigationHandler)
);

registerRoute(
  ({request}) =>  request.destination === 'script' || 
                  request.destination === 'style'  ||
                  request.destination === 'font',
  new CacheFirst({
      cacheName: VERSION+'app-cache',
      plugins: [
      new CacheableResponsePlugin({
          statuses: [0, 200]
      }),
      new ExpirationPlugin({
          maxAgeSeconds: 60 * 60 * 24 * 365,
          maxEntries: 100,
      }),
      ],
  })
);

registerRoute(
  ({url}) =>  url.pathname.substring(0, url.pathname.lastIndexOf("/")) === '/images/website', 
  new CacheFirst({
      cacheName: APP_IMAGE_CACHE,
      plugins: [
      new CacheableResponsePlugin({
          statuses: [0, 200]
      }),
      new ExpirationPlugin({
          maxAgeSeconds: 24 * 3600,
          maxEntries: 50,
      }),
      ],
  })
);

registerRoute(
  ({request, url}) =>  request.destination === 'image' && 
                       url.pathname.substring(0, url.pathname.lastIndexOf("/")) != '/images/website', 
    new StaleWhileRevalidate({
      cacheName: 'dynamic-app-image-cache',
      plugins: [
      new CacheableResponsePlugin({
          statuses: [0, 200]
      }),
      new ExpirationPlugin({
          maxAgeSeconds: 24 * 3600,
          maxEntries: 50,
      }),
      ],
  })
);

self.addEventListener("activate", function(event) {
  console.log('WORKER: activate event in progress.');

  event.waitUntil(
    caches.keys().then(function (keys) {
        return Promise.all(
          keys
            .filter(function (key) {
              return !key.startsWith(VERSION) && !key.match(APP_IMAGE_CACHE);
            })
            .map(function (key) {
              console.log("WORKER: "+key+" deleted")
              return caches.delete(key);
            })
        );
      })
      .then(function() {
        console.log('WORKER: activate completed.');
      })
  );
});

self.addEventListener('online', function(e){
  window.location.reload();
});
self.addEventListener('offline', function(e){
  console.log("event listener offline");
});
