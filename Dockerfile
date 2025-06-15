
FROM php:8.0-apache

RUN apt-get update

RUN apt-get install -y default-mysql-client

RUN docker-php-ext-install mysqli pdo_mysql

RUN a2enmod headers rewrite

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy DB and entry script
COPY ./db/edufun.sql /tmp/edufun.sql
COPY ./entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Enable CORS
RUN printf '\n<IfModule mod_headers.c>\n  Header set Access-Control-Allow-Origin "*"\n  Header set Access-Control-Allow-Methods "GET, POST, OPTIONS"\n</IfModule>\n' \
     >> /etc/apache2/conf-available/cors.conf

RUN a2enconf cors

# Copy source
WORKDIR /var/www/html
COPY ./src/ /var/www/html/

# Change default port
EXPOSE 8080
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-enabled/000-default.conf

ENTRYPOINT ["/entrypoint.sh"]

