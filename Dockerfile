FROM php:8.4-apache

WORKDIR /var/www/html

# Usa a configuração recomendada do PHP para ambientes publicados.
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && mkdir -p /var/lib/php/sessions \
    && sed -ri 's!Listen 80!Listen 10000!g' /etc/apache2/ports.conf \
    && sed -ri 's!:80>!:10000>!g' /etc/apache2/sites-available/*.conf

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html /var/lib/php/sessions

EXPOSE 10000

CMD ["apache2-foreground"]
