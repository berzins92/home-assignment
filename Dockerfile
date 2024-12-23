# Use the official PHP 8.3 image with FPM (FastCGI Process Manager)
FROM php:8.3-fpm

# Set working directory in the container
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

#Xdebug
# Install Xdebug if not already installed
RUN if ! pecl list | grep -q "xdebug"; then \
        pecl install xdebug; \
    else \
        echo "Xdebug already installed"; \
    fi \
    && docker-php-ext-enable xdebug

# Install Composer (PHP dependency manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy custom php.ini file for PHP configuration
COPY ./Docker/php.ini /usr/local/etc/php/conf.d/

# Copy the application code into the container
COPY . /var/www/app
WORKDIR /var/www/app

RUN chown -R www-data:www-data /var/www/html

# Start PHP-FPM
CMD ["php-fpm"]
