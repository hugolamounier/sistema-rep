
const CACHE_FILES = [
    '/offline.html',
    '/asset/css/theme.css',
    '/asset/js/theme.js',
    'images/website/1.webp',
    ];
var VERSION = "v1::";
const APP_CACHE = "app-cache";
const STATIC_CACHE = "static-cache";
self.addEventListener('install', function(event){
    const preFetch = async () => {
        let cacheFiles = CACHE_FILES;
        cacheFiles.forEach(async file => {
            let response = await fetch(new Request(file));
            let cache = await caches.open(VERSION+STATIC_CACHE);
            console.log("WORKER: " + file + " fetched and cached");
            return cache.put(new Request(file), response.clone());
        });
    }
    event.waitUntil(preFetch());
    console.log("WORKER: INSTALLED")
});

self.addEventListener('fetch', function(event){
    var request = event.request;
    if(request.method === "GET")
    {
        event.respondWith(
            caches.match(request).then(function(cached){
                var online_fetch = fetch(request).then(fetchFromNetwork, unableToResolve).catch(unableToResolve);
                console.log('WORKER: fetch event', cached ? '(cached)' : '(network)', event.request.url);
                return cached || online_fetch;

                function fetchFromNetwork(response)
                {
                    if(request.destination === 'image' || request.destination === 'style' || request.destination === 'script' ||
                       request.destination === 'font')
                    {
                        var cacheCopy = response.clone();
                        caches.match(request).then(function(response){
                            if(response == undefined)
                            {
                                caches.open(VERSION+APP_CACHE).then(function(cache){
                                    cache.put(event.request, cacheCopy)
                                }).then(function(){
                                    console.log('WORKER: fetch response stored in cache.', event.request.url);
                                });
                            }
                        });
                    }
                    return response;
                }
                function unableToResolve(error)
                {
                    console.error('WORKER: Serving offline cached error' + error);
                    return caches.open(VERSION+STATIC_CACHE).then(function(cache){
                        return cache.match("offline.html");
                    });
                }
            })
        );
    }
});

self.addEventListener("activate", function(event) {
    console.log('WORKER: activate event in progress.');
  
    event.waitUntil(
      caches.keys().then(function (keys) {
          return Promise.all(
            keys
              .filter(function (key) {
                return !key.startsWith(VERSION);
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