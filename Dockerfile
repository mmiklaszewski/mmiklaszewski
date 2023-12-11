FROM php:8.3-apache

ADD docker/php.ini /usr/local/etc/php/conf.d/php.ini
RUN apt-get update \
    && apt-get install -y \
        git \
        unzip \
        libicu-dev \
        libzip-dev \
    	libcurl4-openssl-dev \
    && apt-get -y --no-install-recommends install g++ zlib1g-dev \
    && rm -rf /var/lib/apt/lists/*


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install intl pdo pdo_mysql zip opcache
RUN apt-get update && \
apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev && \
docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
docker-php-ext-install gd


COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html

RUN docker-php-ext-install pcntl
RUN docker-php-ext-install posix

RUN a2enmod rewrite
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html