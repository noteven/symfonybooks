#syntax=docker/dockerfile:1

# The different stages of this Dockerfile are meant to be built into separate images
# https://docs.docker.com/develop/develop-images/multistage-build/#stop-at-a-specific-build-stage
# https://docs.docker.com/compose/compose-file/#target

ARG PROJECT_DIR=/var/www
ARG COMPOSER_VERSION
ARG PHP_VERSION

###################
# Vendoring Layer #
###################
FROM composer:${COMPOSER_VERSION} AS composer
FROM php:${PHP_VERSION}-fpm-alpine AS vendor
ARG PROJECT_DIR
WORKDIR ${PROJECT_DIR}
# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"
COPY --from=composer --link /usr/bin/composer /usr/bin/composer

# prevent the reinstallation of vendors at every changes in the source code
COPY --link composer.* symfony.* ./
RUN set -eux; \
    if [ -f composer.json ]; then \
		composer install --prefer-dist --no-dev --no-autoloader --no-scripts --no-progress; \
		composer clear-cache; \
    fi

# copy sources
COPY --link  . ./
RUN rm -Rf docker/

RUN set -eux; \
	mkdir -p var/cache var/log; \
    if [ -f composer.json ]; then \
		composer dump-autoload --classmap-authoritative --no-dev; \
		composer dump-env prod; \
		composer run-script --no-dev post-install-cmd; \
		chmod +x bin/console; sync; \
    fi

##################
# Base Layer     #
##################
FROM php:${PHP_VERSION}-fpm-alpine AS base
ARG PROJECT_DIR
WORKDIR ${PROJECT_DIR}

COPY --from=vendor ${PROJECT_DIR} ./

COPY --link docker/php/conf.d $PHP_INI_DIR/conf.d
COPY docker/php/php-fpm.d/zz-docker.conf $PHP_INI_DIR/../php-fpm.d/zz-docker.conf
RUN rm "$PHP_INI_DIR/conf.d/xdebug.ini"

# Install php-fpm-healthcheck dependencies
# https://github.com/renatomefi/php-fpm-healthcheck#requirements
RUN apk add --no-cache fcgi;
COPY --link ./docker/php/fpm-healthcheck.sh /usr/local/bin
RUN chmod +x /usr/local/bin/fpm-healthcheck.sh
HEALTHCHECK --interval=10s --timeout=3s --retries=3 CMD ["fpm-healthcheck"]

# Create logging folder
RUN set -eux; \
	mkdir -p var/cache var/log;

# Install base/common extensions
RUN set -eux; \
	curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions -o - \
    | IPE_ICU_EN_ONLY=0 sh -s opcache intl pdo_pgsql uuid gettext; # Interesting extensions: zip gettext parallel swoole sync

CMD ["php-fpm"]

##################
# Prod Container #
##################
FROM base AS php_prod
ARG PROJECT_DIR
WORKDIR ${PROJECT_DIR}
ENV APP_ENV=prod

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
    rm "$PHP_INI_DIR/conf.d/opcache.dev.ini" && \
    rm "$PHP_INI_DIR/conf.d/xdebug.ini"

#################
# Dev Container #
#################
FROM base AS php_dev
ARG PROJECT_DIR
WORKDIR ${PROJECT_DIR}
ENV APP_ENV=dev
# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"
COPY --from=composer --link /usr/bin/composer /usr/bin/composer

# OpCache/APCU admin tool
RUN curl -sLO --output-dir /usr/local/bin https://github.com/gordalina/cachetool/releases/latest/download/cachetool.phar; \
    chmod +x /usr/local/bin/cachetool.phar;

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" && \
    rm "$PHP_INI_DIR/conf.d/opcache.prod.ini"
COPY ./docker/php/conf.d/xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini

RUN apk add --no-cache --virtual .php-deps $PHPIZE_DEPS linux-headers \
    && pecl install xdebug \
	&& docker-php-ext-enable xdebug \
    && apk del .php-deps

RUN set -eux; \
    if [ -f composer.json ]; then \
		composer install --prefer-dist --dev; \
    fi

RUN set -eux; \
	mkdir -p var/cache var/log; \
    if [ -f composer.json ]; then \
		composer dump-autoload --classmap-authoritative --dev; \
		composer dump-env dev; \
		composer run-script --dev post-install-cmd; \
		chmod +x bin/console; sync; \
    fi

RUN rm -f .env.local.php
