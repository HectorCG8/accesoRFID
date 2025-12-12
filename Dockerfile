# Usa PHP 8.2 con Apache
FROM php:8.2-apache

# Instalar dependencias necesarias para PostgreSQL
RUN apt-get update && \
    apt-get install -y libpq-dev postgresql-client && \
    docker-php-ext-install pdo pdo_pgsql pgsql

# Copiar código PHP/HTML al contenedor
COPY . /var/www/html/

# Opcional: permisos correctos
RUN chown -R www-data:www-data /var/www/html

# Exponer puerto 80
EXPOSE 80
