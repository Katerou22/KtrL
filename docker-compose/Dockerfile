FROM php:7.4-fpm



# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libcurl4-openssl-dev pkg-config libssl-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN pecl install mongodb
# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
RUN docker-php-ext-enable mongodb.so

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands


# Set working directory
WORKDIR /var/www/Traveli


