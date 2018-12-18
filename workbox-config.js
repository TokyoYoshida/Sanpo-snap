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
            urlPattern: /^\/(vue\/home){0,1}$/,
            handler: 'networkFirst',
            options: {
                cacheName: 'page',
                expiration: {
                    maxAgeSeconds: 60 * 60
                }
            }
        },
        {
            urlPattern: /\/api\/.+/,
            handler: 'staleWhileRevalidate',
            options: {
                cacheName: 'api',
                expiration: {
                    maxAgeSeconds: 60 * 60
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
