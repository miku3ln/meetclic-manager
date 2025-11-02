FROM php:8.2-apache

# --- Extensiones PHP ---
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN install-php-extensions \
    mbstring bcmath exif gd opcache \
    pdo_mysql \
    pdo_firebird

# --- Módulos Apache necesarios ---
RUN a2enmod rewrite ssl headers

# Evita el warning de ServerName al iniciar
RUN echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf \
 && a2enconf servername

# --- VHosts (usa tus archivos) ---
# http.conf   → vhost :80 que sirve la app
# ssl.conf    → vhost :443 que sirve la app con SSL
# https.conf  → (OPCIONAL) vhost :80 que SOLO redirige 80→443
COPY http.conf   /etc/apache2/sites-available/projects-http.conf
COPY ssl.conf    /etc/apache2/sites-available/projects-ssl.conf
# (OPCIONAL) descomenta la siguiente línea si quieres forzar HTTPS
# COPY https.conf  /etc/apache2/sites-available/projects-redirect.conf

# Deshabilita defaults y habilita los tuyos
RUN a2dissite 000-default default-ssl || true \
 && a2ensite projects-http projects-ssl
# (OPCIONAL) si copiaste https.conf, habilita el redirect:
# RUN a2ensite projects-redirect

# --- Certificado self-signed para dev ---
RUN mkdir -p /etc/apache2/ssl && \
    openssl req -x509 -nodes -days 365 \
      -subj "/C=EC/ST=Imbabura/L=Otavalo/O=Projects/OU=Dev/CN=localhost" \
      -newkey rsa:2048 \
      -keyout /etc/apache2/ssl/projects.key \
      -out /etc/apache2/ssl/projects.crt

# --- PHP: OPcache y performance ---
COPY php-custom.ini /usr/local/etc/php/conf.d/zzz-custom.ini

# (Opcional) pequeños tunings en Apache
RUN { \
      echo 'KeepAlive On'; \
      echo 'MaxKeepAliveRequests 100'; \
      echo 'KeepAliveTimeout 2'; \
      echo 'Timeout 30'; \
      echo 'HostnameLookups Off'; \
    } > /etc/apache2/conf-available/perf.conf \
 && a2enconf perf

EXPOSE 80 443
