FROM php:7.2-fpm

# PHP 확장 설치
RUN docker-php-ext-install pdo pdo_mysql
