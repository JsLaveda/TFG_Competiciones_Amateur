FROM php:7.4-apache

# Instala extensiones necesarias
RUN docker-php-ext-install mysqli

# Copia tus archivos al contenedor
COPY . /var/www/html/

# Habilita el módulo de reescritura
RUN a2enmod rewrite
