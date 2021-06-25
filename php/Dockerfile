FROM php:7.4-apache
 
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
 
RUN apt-get update \
    && apt-get install -y --no-install-recommends locales apt-utils git libicu-dev g++ libpng-dev libxml2-dev libzip-dev libonig-dev libxslt-dev;
 
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen
 
RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer
 
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql gd opcache intl zip calendar dom mbstring zip gd xsl
RUN pecl install apcu && docker-php-ext-enable apcu
 
WORKDIR /var/www/project

COPY --chown=1000:1000 ./project ./
COPY ./vhosts /etc/apache2/sites-enabled

RUN chmod -R 777 /var/www/project/var/log/dev.log

RUN chown -R www-data /var/www

RUN rm /etc/apache2/sites-enabled/000-default.conf

RUN composer install