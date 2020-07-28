FROM php:7.4-fpm-alpine
# See https://github.com/llaumgui/docker-images/blob/master/php-fpm/7.4/Dockerfile for reference

ARG http_proxy
ENV http_proxy $http_proxy
ENV https_proxy $http_proxy

# Install packages and memcached (as special php-ext)
RUN apk update &&\
	apk upgrade &&\
	apk add --no-cache \
		git \
		openssl \
		libmemcached-libs \
		mysql \
		mysql-client \
    libpng \
    libjpeg-turbo \
		libldap \
		tzdata \
		php-ldap \
		bash &&\
	apk add --virtual .build-dependencies \
		openssh \
		postgresql-dev \
		libjpeg-turbo-dev \
		libpng-dev \
		cyrus-sasl-dev \
		oniguruma-dev \
		openldap-dev \
		libmemcached-dev &&\
	docker-php-source extract &&\
	git clone https://github.com/php-memcached-dev/php-memcached.git /usr/src/php/ext/memcached/ &&\
	docker-php-ext-install memcached &&\
	docker-php-source delete &&\
# Install PHP extensions
  docker-php-ext-configure gd --with-jpeg &&\
	docker-php-ext-configure ldap &&\
  docker-php-ext-install -j$(getconf _NPROCESSORS_ONLN) \
		bcmath \
		gd \
		pdo \
		pdo_mysql \
		ldap \
		gd &&\
# Clean up dev packages
  apk del .build-dependencies &&\
# Prepare PHP
  touch /var/log/php-errors.log &&\
	chown www-data:www-data /var/log/php-errors.log &&\
	mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Copy relevant files
COPY docker_config/app_php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker_config/app_install_composer.sh composer.json /var/www/levelup/

WORKDIR /var/www/levelup

# Install PHP libraries
RUN ./app_install_composer.sh &&\
	rm app_install_composer.sh &&\
	# Do not run scripts as we do this later
	php -d memory_limit=-1 composer.phar install --no-dev --no-scripts --optimize-autoloader &&\
	rm composer.phar

COPY . /var/www/levelup

# Set correct folder permissions
RUN mkdir -p var &&\
	chown -R www-data:www-data var

# Prepare symfony on runtime
ADD docker_config/app_entrypoint.sh ./entrypoint.sh
RUN chmod +x ./entrypoint.sh
ENTRYPOINT ["./entrypoint.sh"]
