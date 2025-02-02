# Use an official PHP image with Apache
FROM ubuntu:20.04

ENV DEBIAN_FRONTEND=noninteractive \
    TZ=Asia/UTC

RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    apache2 \
    libapache2-mod-php \
    php-cli \
    php-mysql \
    php-zip \
    php-xml \
    php-mbstring \
    php-curl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable necessary Apache modules
RUN a2enmod rewrite

FROM php:8.2-apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy project files to the container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Set file permissions
RUN chown -R www-data:www-data /var/www/html/ && chmod -R 755 /var/www/html/

# Install PHP libraries using Composer
#RUN composer require phpoffice/phpspreadsheet phpoffice/phpword
# Install required PHP extensions

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libgd-dev \
    && docker-php-ext-install zip gd

# Install PHP libraries using Composer
RUN composer require phpoffice/phpspreadsheet phpoffice/phpword

# Restart Apache to apply changes
CMD ["apache2-foreground"]
