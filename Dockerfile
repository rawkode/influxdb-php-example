##
# Layer for building extensions
##
FROM php:7-cli-alpine AS ext-build

RUN apk add --update postgresql-dev
RUN docker-php-ext-install pdo_pgsql

##
# Base Layer, copies all the above extensions
##
FROM php:7-cli-alpine AS base

RUN apk add --update postgresql-libs

COPY --from=ext-build /usr/local/etc/php/conf.d/* /usr/local/etc/php/conf.d/
COPY --from=ext-build /usr/local/lib/php/extensions/no-debug-non-zts-20180731/* /usr/local/lib/php/extensions/no-debug-non-zts-20180731/

##
# Dev layer with Dev tools
##
FROM base AS dev

RUN apk add --update git make

COPY --from=composer /usr/bin/composer /usr/bin/composer
