FROM php:8.3-apache

# Diretório de trabalho
WORKDIR /var/www/html

# Instalar dependências do sistema e extensões PHP
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install \
        mysqli \
        pdo \
        pdo_mysql \
        intl \
        zip \
    && rm -rf /var/lib/apt/lists/*

# -----------------------------
# Instalar Composer (EXATAMENTE como você pediu)
# -----------------------------
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
 && php -r "if (hash_file('sha384', 'composer-setup.php') === 'c8b085408188070d5f52bcfe4ecfbee5f727afa458b2573b8eaaf77b3419b0bf2768dc67c86944da1544f06fa544fd47') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }" \
 && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
 && php -r "unlink('composer-setup.php');"

# Copiar arquivos do Composer primeiro (cache de layer)
COPY composer.json composer.lock* ./

# Instalar dependências PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copiar todo o projeto
COPY . .

# Ativar mod_rewrite
RUN a2enmod rewrite

# Apontar DocumentRoot para a pasta public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Permitir overrides via .htaccess para public/
RUN echo "<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" >> /etc/apache2/apache2.conf

# Ajustar permissões do writable
RUN chown -R www-data:www-data /var/www/html/writable \
    && chmod -R 775 /var/www/html/writable

# Expor porta
EXPOSE 80

# Comando padrão
CMD ["apache2-foreground"]