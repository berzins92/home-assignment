# Use the official PHP 8.3 image with FPM (FastCGI Process Manager)
FROM php:8.3-fpm

WORKDIR /var/www/html

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

# Install Composer (PHP dependency manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy custom php.ini configuration file (if you have any custom settings)
COPY ./Docker/php.ini /usr/local/etc/php/conf.d/

# Copy the Laravel application files into the container
COPY . /var/www/html

# Set proper file permissions to avoid permission issues
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html

# Install Composer dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Expose port 8000 for PHP-FPM to work with Laravel's built-in server
EXPOSE 8000

# Set the entry point to start PHP-FPM
CMD ["php-fpm"]
