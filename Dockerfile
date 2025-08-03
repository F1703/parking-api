FROM php:8.3-fpm

ARG UID=1000
ARG GID=1000
ARG APP_ENV=development

# Dependencias del sistema  
RUN apt-get update && apt-get install -y \
    build-essential libpng-dev libonig-dev libxml2-dev zip unzip curl git libpq-dev \
    netcat-openbsd \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd


# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar php.ini personalizado según entorno
COPY ./docker/php/php.ini-${APP_ENV} /usr/local/etc/php/php.ini

# Copiar el entrypoint y asignar permisos de ejecucion
COPY ./docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Crear carpeta del proyecto
WORKDIR /var/www/html

# Copiar archivos si existen
COPY ./src/ /var/www/html/
COPY ./src/.env.example /var/www/html/.env

RUN chown www-data:www-data /var/www/html/.env && chmod 644 /var/www/html/.env

# Crear carpetas necesarias y asignar permisos
RUN mkdir -p storage/logs bootstrap/cache \
    && chown -R www-data:www-data . \
    && chmod -R 775 storage bootstrap/cache

# Crear usuario con el mismo UID/GID del host
RUN usermod -u $UID www-data && groupmod -g $GID www-data

# Instalar dependencias si composer.json existe
RUN if [ -f composer.json ]; then composer install --no-interaction --prefer-dist --optimize-autoloader; fi

# Cambiar a usuario no root
USER www-data

# Entry point personalizado
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
