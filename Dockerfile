FROM php:8.0-apache

RUN apt-get update && apt-get clean \
  && docker-php-ext-install mysqli pdo_mysql \
  && a2enmod headers rewrite \
  && echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN printf '\n<IfModule mod_headers.c>\n  Header set Access-Control-Allow-Origin "*"\n  Header set Access-Control-Allow-Methods "GET, POST, OPTIONS"\n</IfModule>\n' \
     >> /etc/apache2/conf-available/cors.conf \
  && a2enconf cors

WORKDIR /var/www/html
COPY ./src/ /var/www/html/

EXPOSE 8080
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-enabled/000-default.conf

CMD ["sh", "-c", "printenv && apache2-foreground"]

