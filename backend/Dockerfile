FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev \
 && docker-php-ext-install pdo pdo_mysql zip \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

COPY . .

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
