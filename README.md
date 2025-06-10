## УСТАНОВКА ПРОЕКТА
1)Установить composer

composer install

2)Установить фильтр

composer require askedio/laravel5-profanity-filter

3)Установить npm
npm install


4)Создать файл .env и исправить его

cp .env.example .env

php artisan key:generate

для дома
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=computer_club
DB_USERNAME=root
DB_PASSWORD=1234

DB_CONNECTION=mysql
DB_HOST=web.edu
DB_PORT=3306
DB_DATABASE=22065_computerclub
DB_USERNAME=22065
DB_PASSWORD=

5)Сделать миграции и сидеры

php artisan migrate:fresh --seed


## Запуск проекта

1)npm run dev

2)php artisan serve