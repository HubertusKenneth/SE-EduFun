
FROM php:8.0-apache

RUN apt-get update

RUN apt-get install -y default-mysql-client

RUN docker-php-ext-install mysqli pdo_mysql

RUN echo "ServerName 127.0.0.1" > /etc/apache2/conf-available/servername.conf && a2enconf servername

# Copy entrypoint script
COPY ./entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Copy source
WORKDIR /var/www/html
COPY ./src/ /var/www/html/

RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf \
 && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:8080>/' \
       /etc/apache2/sites-enabled/000-default.conf

EXPOSE 8080

ENTRYPOINT ["/entrypoint.sh"]

