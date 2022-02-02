
// names of cache variables
// if any file has been changed from specified
// cache then we should change version of cache name
// in case to delete old cache - only for static caches

// version of application from .env
let app_version = process.env.MIX_APP_VERSION;

// static caches
const imagesCache = 'images-cache-v' + app_version;
const cssCache = 'css-cache-v' + app_version;
const jsCache = 'js-cache-v' + app_version;
const assetsCache = 'assets-cache-v' + app_version;
const pluginsCache = 'plugins-cache-v' + app_version;

// dynamic caches
const pagesCache = 'pages-cache';
const usersProfilesCache = 'users-profiles-cache';
const usersAvatarsCache = 'users-avatars-cache';


// all names of cache variables
let keysOfStaticCaches = [
    imagesCache,
    cssCache,
    jsCache,
    assetsCache,
    pluginsCache
];

let keysOfDynamicCaches = [
    pagesCache,
    usersProfilesCache,
    usersAvatarsCache
];


// urls to cache
const imagesToCache = [
    '/favicon.ico',
    '/assets/images/background.jpg',
    '/assets/icons/16x16.png',
    '/assets/icons/32x32.png',
    '/assets/icons/72x72.png',
    '/assets/icons/96x96.png',
    '/assets/icons/144x144.png',
    '/assets/icons/152x152.png',
    '/assets/icons/192x192.png',
    '/assets/icons/384x384.png',
    '/assets/icons/512x512.png',
    '/assets/icons/apple-touch-icon.png',
    '/assets/images/slider_images/image1.png',
    '/assets/images/slider_images/image2.png',
    '/assets/images/slider_images/image3.png',
    '/assets/images/slider_images/image4.png',
    '/assets/images/slider_images/image5.png',
    '/assets/images/slider_images/image6.png',
    '/assets/images/snake_mini_game/board_background_brown.png',
    '/assets/images/snake_mini_game/board_background_green.png',
    '/assets/images/snake_mini_game/board_background_purple.png'
];

const cssToCache = [
    '/css/app.css',
    '/css/components/send-message.css',
    '/css/custom/classes.css',
    '/css/custom/layout.css',
    '/css/pages/help.css',
    '/css/pages/options.css',
    '/css/pages/profile.css',
    '/css/pages/welcome.css',
    '/css/snake_mini_game/buttons.css',
    '/css/snake_mini_game/food.css',
    '/css/snake_mini_game/options.css',
    '/css/snake_mini_game/score.css',
    '/css/snake_mini_game/snake-mini-game.css',
    '/css/snake_mini_game/snake.css'
];

const jsToCache = [
    '/js/snake_mini_game/food.js',
    '/js/snake_mini_game/game.js',
    '/js/snake_mini_game/grid.js',
    '/js/snake_mini_game/input.js',
    '/js/snake_mini_game/options.js',
    '/js/snake_mini_game/score.js',
    '/js/snake_mini_game/snake.js',
    '/js/app.js'
];

const assetsToCache = [
    '/assets/uncensored_words.json'
];

const pluginsToCache = [
    '/assets/plugins/Bootstrap/bootstrap.css',
    '/assets/plugins/Bootstrap/bootstrap.css.map',
    '/assets/plugins/Bootstrap/bootstrap.min.js',
    '/assets/plugins/Bootstrap/bootstrap.min.js.map',
    '/assets/plugins/BootstrapIcons/fonts/bootstrap-icons.woff',
    '/assets/plugins/BootstrapIcons/fonts/bootstrap-icons.woff2',
    '/assets/plugins/BootstrapIcons/fonts/bootstrap-icons.woff2?856008caa5eb66df68595e734e59580d',
    '/assets/plugins/BootstrapIcons/bootstrap-icons.css',
    '/assets/plugins/cookieBar/jquery.cookieBar.css',
    '/assets/plugins/cookieBar/jquery.cookieBar.js',
    '/assets/plugins/cookieBar/jquery.cookieBar.min.js',
    '/assets/plugins/DataTables/DataTables-1.10.25/images/sort_both.png',
    '/assets/plugins/DataTables/DataTables-1.10.25/images/sort_asc.png',
    '/assets/plugins/DataTables/datatables.js',
    '/assets/plugins/DataTables/datatables.min.js',
    '/assets/plugins/DataTables/datatables.css',
    '/assets/plugins/DataTables/datatables.min.css',
    '/assets/plugins/DataTables/pl.json',
    '/assets/plugins/dropify/css/demo.css',
    '/assets/plugins/dropify/css/dropify.css',
    '/assets/plugins/dropify/css/dropify.min.css',
    '/assets/plugins/dropify/fonts/dropify.eot',
    '/assets/plugins/dropify/fonts/dropify.svg',
    '/assets/plugins/dropify/fonts/dropify.ttf',
    '/assets/plugins/dropify/fonts/dropify.woff',
    '/assets/plugins/dropify/js/dropify.js',
    '/assets/plugins/dropify/js/dropify.min.js',
    '/assets/plugins/jQuery/jquery-3.6.0.min.js',
    '/assets/plugins/jQueryBlockUI/jquery.blockUI.js',
    '/assets/plugins/js-cookie/js.cookie.js',
    '/assets/plugins/js-cookie/js.cookie.min.js',
    '/assets/plugins/js-cookie/js.cookie.min.mjs',
    '/assets/plugins/js-cookie/js.cookie.mjs',
    '/assets/plugins/toastr/toastr.css',
    '/assets/plugins/toastr/toastr.min.css',
    '/assets/plugins/toastr/toastr.js.map',
    '/assets/plugins/toastr/toastr.min.js'

];

const pagesToCache = [
    '/',
    '/gra',
    '/wiadomosc',
    '/strona-offline',
    '/pobierz-gre',
    '/pomoc',
    '/ranking',
    '/ranking/punkty',
    '/ranking/monety',
    '/ranking/easy',
    '/ranking/medium',
    '/ranking/hard',
    '/ranking/speed'
];

const usersAvatarsToCache = [
    '/assets/images/avatar.png'
];


// install event - only once
self.addEventListener('install', (event) => {
    // caching everything
    event.waitUntil(
        caches.open(imagesCache).then(cache => {cache.addAll(imagesToCache)}),
        caches.open(cssCache).then(cache => {cache.addAll(cssToCache);}),
        caches.open(jsCache).then(cache => {cache.addAll(jsToCache);}),
        caches.open(assetsCache).then(cache => {cache.addAll(assetsToCache);}),
        caches.open(pluginsCache).then(cache => {cache.addAll(pluginsToCache);}),
        caches.open(usersAvatarsCache).then(cache => {cache.addAll(usersAvatarsToCache);}),
        caches.open(pagesCache).then(cache => {cache.addAll(pagesToCache);})
    );
});


// activate event
self.addEventListener('activate', (event) => {
    // removing old versions of cache
    // if array of cache keys doesnt contain specified key
    // then removing it from cache storage
    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(keys
                // delete cache when cache's name is NOT in static caches and NOT in dynamics caches
                .filter(key => keysOfStaticCaches.includes(key) == false && keysOfDynamicCaches.includes(key) == false)
                .map(key => caches.delete(key))
            )
        })
    )
});


// fetch event
self.addEventListener('fetch', (event) => {
    // getting cached assets
    event.respondWith(
        caches.match(event.request).then(cacheResponse => {
            // self.registration.scope is for example --> http://127.0.0.1:8000/login
            // so URL will be '/login'
            let pathname = event.request.url.split(self.registration.scope);
            let URL = '/'+pathname[1];

            // checking if URL matches pagesToCache
            if (pagesToCache.includes(URL)) {
                let fetchResponse = fetch(event.request);
                fetchResponse.then(result => {
                    // if there is a internet connection
                    // so we can clone data and replace it with old one
                    if (result.status == 200) {
                        return caches.open(pagesCache).then(cache => {
                            cache.put(URL, result.clone());
                        })
                    }
                });
                // returning new fetched data when there is a internet connenction
                return fetch(event.request)
                    // if there was a problem, for example no internet connection
                    // returning data from old cache
                    .catch(() => {
                        return cacheResponse;
                    });
            }

            // if requested thing is user's avatar image
            else if (URL.includes('/storage/users_avatars/') && URL.includes('?') == false) {
                let fetchResponse = fetch(event.request);
                fetchResponse.then(result => {
                    if (result.status == 200) {
                        return caches.open(usersAvatarsCache).then(cache => {
                            cache.put(URL, result.clone());
                        })
                    }
                });
                return fetch(event.request)
                    .catch(() => {
                        return cacheResponse;
                    })
            }

            // if requested thing is user's profile page
            else if (URL.includes('/profil/')) {
                let fetchResponse = fetch(event.request);
                fetchResponse.then(result => {
                    if (result.status == 200) {
                        return caches.open(usersProfilesCache).then(cache => {
                            cache.put(URL, result.clone());
                        })
                    }
                });
                return fetch(event.request)
                    .catch(() => {
                        return cacheResponse;
                    })
            }

            // if requested thing is static
            else {
                return cacheResponse || fetch(event.request);
            }
        }).catch(() => {
            // there is no internet connection and requested thing isn't cached
            // if requested thing is subpage and it isn't cached - show offline fallback
            if (event.request.destination == 'document') {
                return caches.match('/strona-offline');
            }

        })
    );
});

