# Utilisation de PHP avec Apache
FROM php:8.2-apache

# Installation des extensions PHP requises pour Symfony
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev unzip git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql opcache

# Activation du module Apache pour la réécriture d'URL
RUN a2enmod rewrite

# Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Vérification de l'installation de Composer
RUN composer --version

# Définition du dossier de travail
WORKDIR /var/www/html

# Copie uniquement composer.json et composer.lock pour optimiser le cache Docker
COPY composer.json composer.lock ./

# Installation des dépendances Symfony
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Ensuite, copie tous les fichiers du projet
COPY . .

# Configuration des permissions
RUN chmod -R 777 /var/www/html/var /var/www/html/vendor

# Exposition du port 80
EXPOSE 80

# Commande de démarrage
CMD ["apache2-foreground"]
