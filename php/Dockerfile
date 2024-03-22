FROM php:8.3-cli

RUN apt-get update && \
    apt-get install -y git && \
    apt-get install -y default-mysql-client libicu-dev && \
    docker-php-ext-install pdo pdo_mysql intl && \
    rm -rf /var/lib/apt/lists/*

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

WORKDIR /usr/src/myapp
