#!/bin/bash

echo "🔧 Iniciando script de entrada (entrypoint.sh)..."

# Esperar a que la base de datos esté disponible
echo "⏳ Esperando a que PostgreSQL esté listo..."
until nc -z -v -w30 db 5432
do
  echo "🔁 Esperando a la base de datos..."
  sleep 2
done
echo "✅ PostgreSQL está disponible."

# Instalar dependencias si no existe /vendor
if [ ! -d "vendor" ]; then
  echo "📦 Instalando dependencias..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
else
  echo "📦 Dependencias ya instaladas, omitiendo composer install."
fi

if [ ! -f .env ]; then
  echo "Copiando .env desde .env.example..."
  cp .env.example .env
fi

if ! grep -q "JWT_SECRET=" .env; then
  echo "⛓ Generando JWT_SECRET..."
  php artisan jwt:secret -f
fi

if grep -q "APP_KEY=" .env && php artisan key:generate --show | grep -qv "base64:"; then
  echo "🔑 APP_KEY ya generada."
else
  echo "🔑 Generando APP_KEY..."
  php artisan key:generate --force
fi

php artisan key:generate --show --force

# Ejecutar migraciones forzadas
echo "📂 Ejecutando migraciones..."
php artisan migrate:refresh  --force --seed 

echo "🚀 Servidor PHP-FPM iniciado."
exec php-fpm
