FROM php:8.3-apache

# Diretório de trabalho
WORKDIR /var/www/html

# Copiar todo o projeto
COPY . .

# Ativar mod_rewrite
RUN a2enmod rewrite

# Apontar DocumentRoot para a pasta public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Permitir overrides via .htaccess para public/
RUN echo "<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>" >> /etc/apache2/apache2.conf

# Instalar extensões PHP necessárias
RUN apt-get update && apt-get install -y libicu-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql intl

# Ajustar permissões do writable
RUN chown -R www-data:www-data /var/www/html/writable \
    && chmod -R 775 /var/www/html/writable

# Expor porta
EXPOSE 80

# Comando padrão do container
CMD ["apache2-foreground"]
