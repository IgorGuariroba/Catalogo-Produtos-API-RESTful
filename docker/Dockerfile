# Dockerfile
FROM php:8.2-fpm

# Atualizar os pacotes e instalar dependências necessárias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    zip \
    unzip

# Instalar extensões PHP necessárias para Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl

# Instalar e habilitar a extensão Redis
RUN pecl install redis && docker-php-ext-enable redis

# Composer - Instalar Composer diretamente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Copiar o script de setup para dentro do contêiner
COPY ./docker/setup.sh /setup.sh

# Definir permissão de execução
RUN chmod +x /setup.sh

# Comando de inicialização padrão (rodar o script)
CMD ["/setup.sh"]
