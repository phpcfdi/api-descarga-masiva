FROM debian:bullseye

RUN set -e \
    && export DEBIAN_FRONTEND=noninteractive \
    && apt-get update -y \
    && apt-get dist-upgrade -y \
    && apt-get install -y supervisor zip unzip git wget \
    && wget -q -O - https://packages.sury.org/php/README.txt | bash \
    && apt-get install -y php-cli composer php-zip php-mbstring php-xml php-curl \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY . /opt/api-descarga-masiva
WORKDIR /opt/api-descarga-masiva

RUN set -e \
    && export COMPOSER_ALLOW_SUPERUSER=1 \
    && composer diagnose \
    && composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader \
    && rm -rf "$(composer config cache-dir --global)" "$(composer config data-dir --global)" "$(composer config home --global)"

RUN set -e \
    && cp .env.example .env \
    && php artisan key:generate

EXPOSE 80

COPY ./docker/supervisord.conf /etc/supervisor/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
