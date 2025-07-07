FROM php:8.1-fpm-alpine3.21 AS base

ARG APP_ENV
RUN apk add --no-cache git make

RUN docker-php-ext-install pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# --------------------------
# Dev stage
# --------------------------

FROM base AS dev

# extra tools just for development
RUN apk add --no-cache openssh
