FROM serversideup/php:8.4-fpm-nginx-alpine

WORKDIR /var/www/html

COPY --chown=www-data:www-data . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN php artisan key:generate

# Register migration script as a serversideup entrypoint hook
USER root
COPY docker/start.sh /etc/entrypoint.d/99-migrate.sh
RUN chmod +x /etc/entrypoint.d/99-migrate.sh
USER www-data

EXPOSE 8080
