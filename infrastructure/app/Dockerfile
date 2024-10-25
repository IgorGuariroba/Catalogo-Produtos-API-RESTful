# Dockerfile para laravel_app

# Imagem base do PHP com FPM
FROM php:8.2-fpm

# Define o diretório de trabalho dentro do container
WORKDIR /var/www

RUN usermod -u 1000 www-data

# Instala dependências necessárias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    default-mysql-client \
    libzip-dev \
    nano

# Instala extensões do PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala e configura o Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Copia o conteúdo da aplicação para dentro do container
COPY . /var/www

# Define permissões para o diretório de trabalho
RUN chown -R www-data:www-data /var/www

# Usuário atual passa a ser www-data
USER www-data

# Expor a porta 9003 para o PHP-FPM
EXPOSE 9003

# Comando padrão para iniciar o servidor PHP-FPM
CMD ["php-fpm"]
