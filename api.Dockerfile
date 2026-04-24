FROM php:8.5-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql soap

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN echo "upload_max_filesize=5G" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size=5G" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit=2G" >> /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /var/www/html

COPY . .

COPY default.conf /etc/nginx/conf.d/default.conf
COPY start.sh /start.sh

RUN chmod +x /start.sh

EXPOSE 10000

CMD ["/start.sh"]