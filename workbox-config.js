const WorkboxBuildWebpackPlugin = require('workbox-webpack-plugin');

module.exports = {
    cacheId: 'sanpo-snap',
    globPatterns: ['**/*.{js,css}'],
    globIgnores: ['**/*.pc*'],
    globDirectory: 'public/',
    swDest: 'public/sw.js',
    skipWaiting: true,
    clientsClaim: false,
    runtimeCaching: [
        {
            urlPattern: '/',
            handler: 'networkFirst',
            options: {
                cacheName: 'page',
                expiration: {
                    maxAgeSeconds: 60 * 60 * 24
                }
            }
        },
        {
            urlPattern: /\/api\/.+/,
            handler: 'networkFirst',
            options: {
                cacheName: 'api',
                expiration: {
                    maxAgeSeconds: 60 * 60 * 24
                }
            }
        },
        {
            urlPattern: /\.(png|svg|woff|ttf|eot)/,
            handler: 'cacheFirst',
            options: {
                cacheName: 'assets',
                expiration: {
                    maxAgeSeconds: 60 * 60 * 24
                }
            }
        }
    ]
};
