FROM php:8.2-apache
# Install MYSQL PDO
RUN apt-get update && apt-get install -y libonig-dev libzip-dev default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql mysqli