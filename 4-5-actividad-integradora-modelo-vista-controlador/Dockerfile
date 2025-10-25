FROM php:8.2-cli

# Instalar extensiones PHP comunes
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libicu-dev \
    libonig-dev \
    libsodium-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && docker-php-ext-install intl \
    && docker-php-ext-install opcache \
    && docker-php-ext-install sodium \
    && apt-get clean

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . .

# Exponer puerto
EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/html"]