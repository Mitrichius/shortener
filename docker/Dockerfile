FROM php:7.4-fpm
ARG TIMEZONE
ARG GEOIP_LICENSE

COPY ./ /project
WORKDIR /project

RUN cp /project/docker/wait-for-it.sh /usr/bin/wait-for-it
RUN chmod +x /usr/bin/wait-for-it

RUN cp /project/docker/.env /project/.env.local

# Timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
&& printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
&& "date"

# Install libs
RUN apt-get update && apt-get install -y \
    build-essential \
    git \
    curl \
    zip \
    unzip 

# GeoIP
RUN curl -o /opt/GeoLite2-City.tar.gz "https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-City&license_key=${GEOIP_LICENSE}&suffix=tar.gz"
RUN tar -xzvf /opt/GeoLite2-City.tar.gz -C /opt/ --wildcards "*.mmdb"
RUN find /opt -name "*.mmdb" -exec mv -t /opt {} +

# PHP Browscap 
RUN curl -o /opt/php_browscap.ini "http://browscap.org/stream?q=PHP_BrowsCapINI" 
RUN echo '[browscap] \n\
browscap = /opt/php_browscap.ini \n\
' >> /usr/local/etc/php/conf.d/ext-browscap.ini

# PHP Extensions
RUN docker-php-ext-install pdo pdo_mysql

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

EXPOSE 9000
COPY docker/entrypoint.sh "/root"
ENTRYPOINT ["bash", "-eu", "/root/entrypoint.sh"]