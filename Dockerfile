# Usa PHP 8.2 con Apache
FROM php:8.2-apache

# Habilitar extensiones necesarias para PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql pgsql

# Copiar tu código PHP/HTML al contenedor
COPY ./php-app /var/www/html/

# Cambiar permisos si es necesario
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto 80 (Apache)
EXPOSE 80

# Apache ya se inicia automáticamente con esta imagen
