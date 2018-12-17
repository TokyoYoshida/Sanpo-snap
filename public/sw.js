/**
 * Welcome to your Workbox-powered service worker!
 *
 * You'll need to register this file in your web app and you should
 * disable HTTP caching for this file too.
 * See https://goo.gl/nhQhGp
 *
 * The rest of the code is auto-generated. Please don't update this file
 * directly; instead, make changes to your Workbox build configuration
 * and re-run your build process.
 * See https://goo.gl/2aRDsh
 */

importScripts("https://storage.googleapis.com/workbox-cdn/releases/3.6.3/workbox-sw.js");

workbox.core.setCacheNameDetails({prefix: "sanpo-snap"});

workbox.skipWaiting();

/**
 * The workboxSW.precacheAndRoute() method efficiently caches and responds to
 * requests for URLs in the manifest.
 * See https://goo.gl/S9QRab
 */
self.__precacheManifest = [
  {
    "url": "css/app.css",
    "revision": "7fbb192cf85383f93d8c49c2ff114d1e"
  },
  {
    "url": "js/app.js",
    "revision": "d9cd410747be7e0e33d269e5c5110af3"
  }
].concat(self.__precacheManifest || []);
workbox.precaching.suppressWarnings();
workbox.precaching.precacheAndRoute(self.__precacheManifest, {});

workbox.routing.registerRoute("/", workbox.strategies.networkFirst({ "cacheName":"page", plugins: [new workbox.expiration.Plugin({"maxAgeSeconds":86400,"purgeOnQuotaError":false})] }), 'GET');
workbox.routing.registerRoute(/\/api\/.+/, workbox.strategies.networkFirst({ "cacheName":"api", plugins: [new workbox.expiration.Plugin({"maxAgeSeconds":86400,"purgeOnQuotaError":false})] }), 'GET');
workbox.routing.registerRoute(/\.(png|svg|woff|ttf|eot)/, workbox.strategies.cacheFirst({ "cacheName":"assets", plugins: [new workbox.expiration.Plugin({"maxAgeSeconds":86400,"purgeOnQuotaError":false})] }), 'GET');
