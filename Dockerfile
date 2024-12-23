# Use the official PHP 8.3 image with FPM (FastCGI Process Manager)
FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libxml2-dev \
    libzip-dev \
    git \
    unzip \
    nano \
    libxrender1 \
    libxext6 \
    libvpx-dev \
    libonig-dev \
    default-mysql-client && \
    docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
    docker-php-ext-install gd pdo pdo_mysql zip bcmath && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-enable bcmath

#Xdebug
# Install Xdebug if not already installed
RUN if ! pecl list | grep -q "xdebug"; then \
        pecl install xdebug; \
    else \
        echo "Xdebug already installed"; \
    fi \
    && docker-php-ext-enable xdebug

# Install Composer (PHP dependency manager)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY ./Docker/php.ini /usr/local/etc/php/conf.d/

COPY . /var/www/html
WORKDIR /var/www/html

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN chown -R www-data:www-data /var/www/html

# Start PHP-FPM
CMD ["php-fpm"]
