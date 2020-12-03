FROM php:7.3-apache
MAINTAINER "Xavier Garnier"

ENV VERSION=1.3
ENV DOWNLOAD_URL=https://ltb-project.org/archives/ltb-project-self-service-password-${VERSION}.tar.gz
COPY apache.conf /etc/apache2/sites-available/self-service-password.conf

RUN set -x \
    && apt-get update \
    && apt-get install -y libldap2-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install ldap \
    && apt-get purge -y --auto-remove libldap2-dev && \
    a2enmod rewrite && \
    curl ${DOWNLOAD_URL} -o ssp.tgz && \
    tar zxvf ssp.tgz && \
    mv ltb-project-self-service-password-${VERSION} /usr/local/self-service-password && \
    chown -R www-data:www-data /usr/local/self-service-password && chmod 750 -R /usr/local/self-service-password && \
    a2ensite self-service-password

COPY config.php /usr/local/self-service-password/conf/config.inc.php
