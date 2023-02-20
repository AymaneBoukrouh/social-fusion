FROM php:8.2-apache

# enable apache mod_rewrite
RUN a2enmod rewrite && service apache2 restart

# install PDO and MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# set working directory
WORKDIR /var/www/html

# copy apache config
COPY ./apache-config.conf /etc/apache2/sites-available/000-default.conf

# copy source code
COPY . .
