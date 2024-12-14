FROM php:8.4-fpm

# Обновляем пакеты и устанавливаем supervisor и inotify-tools
RUN apt-get update && apt-get install -y supervisor inotify-tools && rm -rf /var/lib/apt/lists/*

# Закачиваем скрипт install-php-extensions
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Устанавливаем PHP-расширения
RUN install-php-extensions @composer-2.0.2 @fix_letsencrypt amqp bcmath bz2 calendar curl exif gd gettext gmp imagick imap intl json ldap mbstring memcached mongodb msgpack mysqli opcache pcntl pdo_mysql pdo_pgsql pgsql redis shmop soap sockets sysvmsg sysvsem sysvshm tidy uuid xdebug xml yaml zip

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Копируем скрипт наблюдения
COPY ../../scripts/worker_watch.sh /usr/local/bin/worker_watch.sh
RUN chmod +x /usr/local/bin/worker_watch.sh

# Копируем php.ini
COPY ../../config/php-worker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Открываем порт для supervisord (опционально)
EXPOSE 9001

# Указываем команду запуска supervisor
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]