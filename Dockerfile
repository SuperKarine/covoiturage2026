# syntax=docker/dockerfile:1

# Phase 1: Dépendances (développement)
FROM php:8.2-cli AS deps

WORKDIR /app

# Installe MongoDB + Composer + outils pour Bootstrap
RUN apt-get update && apt-get install -y \
    unzip curl git \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    wget \
 && pecl install mongodb-1.21.0 \
 && docker-php-ext-enable mongodb \
 && curl -sS https://getcomposer.org/installer | php \
 && mv composer.phar /usr/local/bin/composer \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# Télécharge Bootstrap dans le stage de développement 
RUN wget -O bootstrap.zip https://github.com/twbs/bootstrap/releases/download/v5.3.0/bootstrap-5.3.0-dist.zip \
 && unzip bootstrap.zip -d /tmp/bootstrap \
 && mkdir -p /app/public/assets/css /app/public/assets/js \  
 && cp /tmp/bootstrap/bootstrap-5.3.0-dist/css/bootstrap.min.css /app/public/assets/css/ \  
 && cp /tmp/bootstrap/bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js /app/public/assets/js/ \  
 && rm -rf bootstrap.zip /tmp/bootstrap

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction

COPY . /app


# Phase 2: Image finale (production)
FROM php:8.2-apache AS final

# Installation extensions PHP requises + outils pour Bootstrap
RUN apt-get update && apt-get install -y \
    unzip curl git \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    wget \
 && pecl install mongodb-1.21.0 \
 && docker-php-ext-enable mongodb \
 && docker-php-ext-install pdo pdo_mysql \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# Télécharge et installe Bootstrap en production 
RUN wget -O bootstrap.zip https://github.com/twbs/bootstrap/releases/download/v5.3.0/bootstrap-5.3.0-dist.zip \
 && unzip bootstrap.zip -d /tmp/bootstrap \
 && mkdir -p /var/www/html/public/assets/css /var/www/html/public/assets/js \  
 && cp /tmp/bootstrap/bootstrap-5.3.0-dist/css/bootstrap.min.css /var/www/html/public/assets/css/ \  
 && cp /tmp/bootstrap/bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js /var/www/html/public/assets/js/ \  
 && rm -rf bootstrap.zip /tmp/bootstrap

# Installation de  Composer 
RUN curl -sS https://getcomposer.org/installer | php \
 && mv composer.phar /usr/local/bin/composer

# Config Apache
RUN a2enmod rewrite
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Copie les vendors générés par deps
COPY --from=deps /app/vendor /var/www/html/vendor

# Copie le code
COPY ./public /var/www/html/public
COPY ./src /var/www/html/src
COPY ./config /var/www/html/config

# Copie des fichiers Bootstrap du stage de développement 
COPY --from=deps /app/public/assets /var/www/html/public/assets  

# Apache custom config
COPY ./apache.conf /etc/apache2/conf-available/myapp.conf
RUN a2enconf myapp

# Définir le DocumentRoot vers /public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Sécurité : utiliser www-data
USER www-data