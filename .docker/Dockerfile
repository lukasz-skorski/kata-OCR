FROM php:7.4-fpm

SHELL ["/bin/bash", "-o", "pipefail", "-c"]
RUN apt-get update -y --fix-missing \
    && apt-get upgrade -y \
    && apt-get install --no-install-recommends -y \
        nano \
		acl \
		file \
		gettext \
		git \
		wget \
		cron \
		supervisor \
        zip \
        unzip
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html
