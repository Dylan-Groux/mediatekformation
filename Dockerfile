# Utilisation de l'image PHP avec Apache
FROM php:8.2-apache

# Installation des extensions PHP requises pour Symfony
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql opcache

# Activation du module Apache pour la réécriture d'URL
RUN a2enmod rewrite

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définition du dossier de travail
WORKDIR /var/www/html

# Copie des fichiers du projet
COPY . /var/www/html/

# Copie des fichiers Composer en premier pour optimiser le cache
COPY composer.json composer.lock ./
RUN composer --version


# Installation des dépendances Symfony
RUN composer install --no-dev --optimize-autoloader

# Configuration des permissions
RUN chown -R www-data:www-data /var/www/html/var /var/www/html/public

# Ensuite, on copie le reste des fichiers
COPY . .

# Exposition du port 80
EXPOSE 80

# Commande de démarrage
CMD ["apache2-foreground"]
