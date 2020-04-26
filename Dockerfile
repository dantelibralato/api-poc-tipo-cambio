FROM php:7.4-alpine


RUN set -ex \
    && apk update \
    && apk add --no-cache libffi-dev icu libsodium libressl-dev \
    && apk add --no-cache --virtual build-dependencies icu-dev g++ make autoconf libsodium-dev \
    && docker-php-source extract \
    && pecl install swoole sodium mongodb \
    && docker-php-ext-enable swoole sodium mongodb \
	&& docker-php-source delete \
    && cd  / && rm -fr /src \
    && apk del build-dependencies \
    && rm -rf /tmp/* \
	


#COPY --from=builder --chown=www-data:www-data /app /var/www

#COPY docker/php.ini /usr/local/etc/php/php.ini

USER www-data

COPY . /var/www/html

WORKDIR /var/www/html

EXPOSE 1215

CMD ["php", "artisan","swoole:http","start"]





