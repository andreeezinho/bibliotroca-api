## backend-api
FROM php:8.5-fpm

# Instalar dependências necessárias incluindo a extensão PDO MySQL
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libssl-dev \
    mariadb-client \
    libxml2-dev \
    && docker-php-ext-install soap pdo pdo_mysql

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# variaveis env primeiro 
RUN echo "variables_order=\"EGPCS\"" >> /usr/local/etc/php/conf.d/custom.ini

# definir tamanho de upload de arquivos
RUN echo "upload_max_filesize=5G" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size=5G" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit=2G" >> /usr/local/etc/php/conf.d/uploads.ini

# diretorio de trabalho
WORKDIR /var/www/html

EXPOSE 10000
