FROM ubuntu:22.04

ARG WWWGROUP=www-data
ARG NODE_VERSION=20

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC
ENV SUPERVISOR_PHP_COMMAND="/usr/bin/php -d variables_order=EGPCS /var/www/html/artisan serve --host=0.0.0.0 --port=80"

ADD https://api.github.com/repos/yamut/mitt/git/refs/heads/main /root/version.json

COPY start-container /usr/local/bin/start-container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY php.ini /etc/php/8.3/cli/conf.d/99-sail.ini

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN apt-get update \
    && mkdir -p /etc/apt/keyrings \
    && apt-get install -y gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python2 dnsutils librsvg2-bin fswatch \
    && curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0x14aa40ec0831756756d7f66c4f4ea0aae5267a6c' | gpg --dearmor | tee /etc/apt/keyrings/ppa_ondrej_php.gpg > /dev/null \
    && echo "deb [signed-by=/etc/apt/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu jammy main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get install -y php8.3-cli \
       php8.3-curl \
       php8.3-mbstring \
       php8.3-xml php8.3-bcmath \
       php8.3-intl php8.3-readline \
       php8.3-msgpack php8.3-igbinary php8.3-redis \
       php8.3-pcov php8.3-xdebug \
    && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
    && apt-get update \
    && apt-get install -y nodejs \
    && npm install -g npm \
    && apt-get update \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && setcap "cap_net_bind_service=+ep" /usr/bin/php8.3 \
    && groupadd --force sail \
    && useradd -ms /bin/bash --no-user-group -u 1337 sail \
    && git clone -b main https://github.com/yamut/mitt.git . \
    && if [ ! -d /.composer ]; then mkdir /.composer; fi \
    && chmod -R ugo+rw /.composer \
    && cp .env.example .env \
    && composer i --no-dev \
    && npm ci \
    && npm run build \
    && npm ci --production \
    && php artisan key:generate \
    && chmod +x /usr/local/bin/start-container

EXPOSE 80

ENTRYPOINT ["start-container"]
