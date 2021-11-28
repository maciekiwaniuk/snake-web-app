/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/process/browser.js":
/*!*****************************************!*\
  !*** ./node_modules/process/browser.js ***!
  \*****************************************/
/***/ ((module) => {

// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) { return [] }

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!****************************!*\
  !*** ./resources/js/sw.js ***!
  \****************************/
/* provided dependency */ var process = __webpack_require__(/*! process/browser.js */ "./node_modules/process/browser.js");
// names of cache variables
// if any file has been changed from specified
// cache then we should change version of cache name
// in case to delete old cache - only for static caches
// version of application from .env
var app_version = process.env.MIX_APP_VERSION; // static caches

var imagesCache = 'images-cache-v' + app_version;
var cssCache = 'css-cache-v' + app_version;
var jsCache = 'jss-cache-v' + app_version;
var assetsCache = 'assets-cache-v' + app_version;
var pluginsCache = 'plugins-cache-v' + app_version; // dynamic caches

var pagesCache = 'pages-cache';
var usersProfilesCache = 'users-profiles-cache';
var usersAvatarsCache = 'users-avatars-cache'; // all names of cache variables

var keysOfStaticCaches = [imagesCache, cssCache, jsCache, assetsCache, pluginsCache];
var keysOfDynamicCaches = [pagesCache, usersProfilesCache, usersAvatarsCache]; // urls to cache

var imagesToCache = ['/favicon.ico', '/assets/images/background.jpg', '/assets/icons/16x16.png', '/assets/icons/32x32.png', '/assets/icons/72x72.png', '/assets/icons/96x96.png', '/assets/icons/144x144.png', '/assets/icons/152x152.png', '/assets/icons/192x192.png', '/assets/icons/384x384.png', '/assets/icons/512x512.png', '/assets/icons/apple-touch-icon.png', '/assets/images/slider-images/image1.jpg', '/assets/images/slider-images/image2.jpg', '/assets/images/slider-images/image3.jpg', '/assets/images/slider-images/image4.jpg', '/assets/images/slider-images/image5.jpg', '/assets/images/help_images/download_files/tip_1.jpg', '/assets/images/help_images/download_files/tip_2.jpg', '/assets/images/help_images/download_files/tip_3.jpg'];
var cssToCache = ['/css/custom/classes.css', '/css/custom/layout.css', '/css/pages/options.css', '/css/pages/profile.css', '/css/pages/help.css', '/css/snake_mini_game/snake.css', '/css/app.css'];
var jsToCache = ['/js/snake_mini_game/game.js', '/js/snake_mini_game/snake.js', '/js/app.js'];
var assetsToCache = ['/strona-offline', '/assets/uncensored_words.json'];
var pluginsToCache = ['/assets/plugins/Bootstrap/bootstrap.css', '/assets/plugins/Bootstrap/bootstrap.css.map', '/assets/plugins/Bootstrap/bootstrap.min.js', '/assets/plugins/Bootstrap/bootstrap.min.js.map', '/assets/plugins/BootstrapIcons/fonts/bootstrap-icons.woff', '/assets/plugins/BootstrapIcons/fonts/bootstrap-icons.woff2', '/assets/plugins/BootstrapIcons/fonts/bootstrap-icons.woff2?856008caa5eb66df68595e734e59580d', '/assets/plugins/BootstrapIcons/bootstrap-icons.css', '/assets/plugins/DataTables/DataTables-1.10.25/images/sort_both.png', '/assets/plugins/DataTables/DataTables-1.10.25/images/sort_asc.png', '/assets/plugins/DataTables/datatables.js', '/assets/plugins/DataTables/datatables.min.js', '/assets/plugins/DataTables/datatables.css', '/assets/plugins/DataTables/datatables.min.css', '/assets/plugins/DataTables/pl.json', '/assets/plugins/dropify/css/demo.css', '/assets/plugins/dropify/css/dropify.css', '/assets/plugins/dropify/css/dropify.min.css', '/assets/plugins/dropify/fonts/dropify.eot', '/assets/plugins/dropify/fonts/dropify.svg', '/assets/plugins/dropify/fonts/dropify.ttf', '/assets/plugins/dropify/fonts/dropify.woff', '/assets/plugins/dropify/js/dropify.js', '/assets/plugins/dropify/js/dropify.min.js', '/assets/plugins/jQuery/jquery-3.6.0.min.js', '/assets/plugins/jQueryBlockUI/jquery.blockUI.js', '/assets/plugins/toastr/toastr.css', '/assets/plugins/toastr/toastr.min.css', '/assets/plugins/toastr/toastr.js.map', '/assets/plugins/toastr/toastr.min.js', '/assets/plugins/cookieBar/jquery.cookieBar.css', '/assets/plugins/cookieBar/jquery.cookieBar.js', '/assets/plugins/cookieBar/jquery.cookieBar.min.js'];
var pagesToCache = ['/', '/pobierz-gre', '/pomoc', '/ranking', '/ranking/punkty', '/ranking/monety', '/ranking/easy', '/ranking/medium', '/ranking/hard', '/ranking/speed'];
var usersAvatarsToCache = ['/assets/images/avatar.png']; // install event - only once

self.addEventListener('install', function (event) {
  // caching everything
  event.waitUntil(caches.open(imagesCache).then(function (cache) {
    cache.addAll(imagesToCache);
  }), caches.open(cssCache).then(function (cache) {
    cache.addAll(cssToCache);
  }), caches.open(jsCache).then(function (cache) {
    cache.addAll(jsToCache);
  }), caches.open(assetsCache).then(function (cache) {
    cache.addAll(assetsToCache);
  }), caches.open(pluginsCache).then(function (cache) {
    cache.addAll(pluginsToCache);
  }), caches.open(usersAvatarsCache).then(function (cache) {
    cache.addAll(usersAvatarsToCache);
  }), caches.open(pagesCache).then(function (cache) {
    cache.addAll(pagesToCache);
  }));
}); // activate event

self.addEventListener('activate', function (event) {
  // removing old versions of cache
  // if array of cache keys doesnt contain specified key
  // then removing it from cache storage
  event.waitUntil(caches.keys().then(function (keys) {
    return Promise.all(keys // delete cache when cache's name is NOT in static caches and NOT in dynamics caches
    .filter(function (key) {
      return keysOfStaticCaches.includes(key) == false && keysOfDynamicCaches.includes(key) == false;
    }).map(function (key) {
      return caches["delete"](key);
    }));
  }));
}); // fetch event

self.addEventListener('fetch', function (event) {
  // getting cached assets
  event.respondWith(caches.match(event.request).then(function (cacheResponse) {
    // self.registration.scope is for example --> http://127.0.0.1:8000/login
    // so URL will be '/login'
    var pathname = event.request.url.split(self.registration.scope);
    var URL = '/' + pathname[1]; // checking if URL matches pagesToCache

    if (pagesToCache.includes(URL)) {
      var fetchResponse = fetch(event.request);
      fetchResponse.then(function (result) {
        // if there is a internet connection
        // so we can clone data and replace it with old one
        if (result.status == 200) {
          return caches.open(pagesCache).then(function (cache) {
            cache.put(URL, result.clone());
          });
        }
      }); // returning new fetched data when there is a internet connenction

      return fetch(event.request) // if there was a problem, for example no internet connection
      // returning data from old cache
      ["catch"](function () {
        return cacheResponse;
      });
    } // if requested thing is user's avatar
    else if (URL.includes('/storage/users_avatars/') && URL.includes('?') == false) {
      var _fetchResponse = fetch(event.request);

      _fetchResponse.then(function (result) {
        if (result.status == 200) {
          return caches.open(usersAvatarsCache).then(function (cache) {
            cache.put(URL, result.clone());
          });
        }
      });

      return fetch(event.request)["catch"](function () {
        return cacheResponse;
      });
    } // if requested thing is user's profile
    else if (URL.includes('/profil/')) {
      var _fetchResponse2 = fetch(event.request);

      _fetchResponse2.then(function (result) {
        if (result.status == 200) {
          return caches.open(usersProfilesCache).then(function (cache) {
            cache.put(URL, result.clone());
          });
        }
      });

      return fetch(event.request)["catch"](function () {
        return cacheResponse;
      });
    } // if requested thing is static
    else {
      return cacheResponse || fetch(event.request);
    }
  })["catch"](function () {
    // there is no internet connection and requested thing isn't cached
    // if requested thing is subpage and it isn't cached - show offline fallback
    if (event.request.destination == "document") {
      return caches.match('/strona-offline');
    }
  }));
});
})();

/******/ })()
;