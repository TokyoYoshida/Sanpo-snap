# Sanpo Snap

[Sanpo-snap](https://sanpo-snap.net/) is a service to share photos of walks.

This service is implemented using Laravel and can also be used as a template when you create a new service.

## Feature

- [x]  It can be used as a service template for laravel(Laravel 5.7)
- [x]  and Vuejs. But it's not SPA.(Vuejs  2.5.7)
- [x]  Mail auth.
- [x]  SNS auth.(Now, Only github is supported, but other SNS can be support easily.)
- [x]  PWA.(iOS authentication has not been done yet)
- [x]  User profile page & following user.

## Install

required:

 php 7.2.0

 mysql 8.0.3

 git, composer, npm

    git clone [https://github.com/TokyoYoshida/Sanpo-snap](https://github.com/TokyoYoshida/Sanpo-snap)
    cd Sanpo-snap
    cp .env.example .env
    composer install
    npm install
    npm run production
    php artisan key:generate
    php artisan config:clear
    php artisan config:cache
    php artisan migrate
    php artisan serve

## License

MIT

## Contact

yoshidaforpublic@gmail.com  
