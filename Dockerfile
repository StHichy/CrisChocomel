FROM php:8.2-apache

# Instala extensões necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd

# ATIVA O MOD_REWRITE DO APACHE (Essencial para as rotas do Laravel funcionarem)
RUN a2enmod rewrite

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos do projeto
COPY . /var/www/html

# Configura a pasta public como raiz do Apache e permite override do .htaccess
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -s 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -s 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Libera o AllowOverride para que o arquivo .htaccess da pasta public funcione
RUN echo '<Directory /var/www/html/public/>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala dependências
RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80