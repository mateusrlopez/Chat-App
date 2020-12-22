FROM php:7.4-apache

RUN docker-php-ext-install pdo pdo_mysql 

COPY ./src /var/www/html
COPY .docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY .docker/apache/start.sh /usr/local/bin/start

RUN usermod -u 1000 www-data \
    && groupmod -g 1000 www-data \
    && chmod u+x /usr/local/bin/start \
    && a2enmod rewrite

CMD [ "/usr/local/bin/start" ]