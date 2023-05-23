FROM php:8.1-fpm

RUN apt-get update && \
    apt-get install -y nginx && \
    apt-get install -y default-libmysqlclient-dev && \
    rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mysqli

RUN mv /etc/nginx/sites-available/default /etc/nginx/sites-available/default.bak
COPY nginx.conf /etc/nginx/sites-available/
RUN mv /etc/nginx/sites-available/nginx.conf /etc/nginx/sites-available/default

COPY . /var/www/html/

EXPOSE 80

CMD ["sh", "-c", "service nginx start && php-fpm"]