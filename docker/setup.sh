#!/bin/bash

# Entrar no diretório da aplicação
cd /var/www/html

# Instalar Laravel se não houver composer.json (ou seja, se o projeto não estiver configurado)
if [ ! -f "composer.json" ]; then
    echo "Criando projeto Laravel..."
    composer create-project --prefer-dist laravel/laravel .
fi

# Gerar chave da aplicação se ainda não estiver gerada
if ! grep -q "APP_KEY=" .env; then
    echo "Gerando chave da aplicação..."
    php artisan key:generate
fi

# Executar o PHP-FPM
php-fpm
