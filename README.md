## Features
- Vue cli 3 + Laravel 5.6 integration!
- Example todo app
- Babel 7
- ESLint(standard + plugin vue recommended)
- Stylus with [automatic-imports](https://cli.vuejs.org/guide/css.html#automatic-imports)
- Vue Router
- Bootstrap 4
- [vue-plugin-axios](https://github.com/iliyaZelenko/vue-plugin-axios)
- [Laravel Cors package](https://github.com/barryvdh/laravel-cors)
- Tests with jest + cypress

### Installation

1. `git clone https://github.com/iliyaZelenko/vue-cli-laravel-starter.git`
2. `composer install` 
3. set db connection and run `php artisan migrate` and `php artisan db:seed`
4. `cd frontend` and `yarn` or `npm install`

### To Work With the Laravel
You can start server with `php artisan serve`

Set laravel url in **frontend/.env** file(VUE_APP_BACKEND)


### To Work With the Frontend
``` sh
cd frontend

# development
yarn serve # OR npm run serve

# build for production:
yarn build # OR npm run build
```

After build you can see the production version through the laravel url.


![Imgur](https://i.imgur.com/XKjvySZl.png)
![Imgur](https://i.imgur.com/vexNbzzl.png)
