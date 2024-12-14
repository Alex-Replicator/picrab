FROM php:8.4-fpm

# Закачиваем скрипт install-php-extensions
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions @composer-2.0.2 @fix_letsencrypt amqp bcmath bz2 calendar curl exif gd gettext gmp imagick imap intl json ldap mbstring memcached mongodb msgpack mysqli opcache pcntl pdo_mysql pdo_pgsql pgsql redis shmop soap sockets sysvmsg sysvsem sysvshm tidy uuid xdebug xml yaml zip



