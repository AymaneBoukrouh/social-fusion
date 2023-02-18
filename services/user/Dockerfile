FROM php:8.2-apache

# install PDO and MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# set working directory
WORKDIR /var/www/html

# copy source code
COPY . .
