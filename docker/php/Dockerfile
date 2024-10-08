FROM php:8.3-fpm

RUN apt-get update \
    && apt-get install -y \
        libssl-dev \
        libcurl4-openssl-dev \
        pkg-config \
        libz-dev \
        curl \
        git \
        libzip-dev \
        libpq-dev \
    && rm -rf /var/lib/apt/lists/*

RUN pecl install mongodb xdebug \
    && docker-php-ext-enable xdebug mongodb

RUN docker-php-ext-install zip

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer

RUN useradd -m usernew && \
    echo 'usernew:user' | chpasswd && \
    usermod -aG sudo usernew && \
    echo 'usernew ALL=(ALL) NOPASSWD: ALL' >> /etc/sudoers && \
    usermod -s /bin/bash usernew

WORKDIR /var/www/html

USER usernew

COPY --chown=usernew:usernew . /var/www/html

EXPOSE 9000

CMD ["php-fpm"]
