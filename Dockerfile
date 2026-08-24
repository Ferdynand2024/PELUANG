FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    zip unzip libzip-dev libgd-dev libpng-dev \
    libjpeg-dev libfreetype6-dev libonig-dev \
    curl git nodejs npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql mbstring bcmath opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --optimize-autoloader --no-scripts --no-interaction --ignore-platform-reqs

RUN npm install && npm run build

RUN cp .env.example .env && php artisan key:generate

EXPOSE 8000

CMD php artisan config:cache && php artisan migrate --force && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=8000
