FROM php:8.1-fpm-alpine3.21 AS base

ARG APP_ENV
RUN apk add --no-cache git make

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .
