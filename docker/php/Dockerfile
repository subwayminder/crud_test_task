ARG PHP_VERSION=8.1
FROM php:${PHP_VERSION}-fpm-alpine

#####################################
# System:
#####################################

# Set UTC timezone
RUN echo "UTC" > /etc/timezone

#####################################
# Software:
#####################################

# Install php dependencies
RUN apk add --no-cache --virtual .phpize-deps ${PHPIZE_DEPS}

#####################################
# PHP Extensions:
#####################################

# Install MySQL extension
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-enable pdo_mysql

#####################################
# Composer:
#####################################
RUN (curl -s https://getcomposer.org/installer | php)
RUN mv composer.phar /usr/local/bin/composer

#####################################
# ENTRYPOINT:
#####################################
COPY docker/php/docker-entrypoint.sh /usr/local/bin/
RUN dos2unix /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

#####################################
# Clean:
#####################################
RUN apk del .phpize-deps
RUN rm -rf "/etc/apk/cache"

#####################################
# Final:
#####################################

# Configuration php
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY docker/php/php-fpm.d/www.conf "$PHP_INI_DIR/../php-fpm.d/zz-www.conf"

WORKDIR /var/www/html/

ENTRYPOINT ["docker-entrypoint.sh"]
