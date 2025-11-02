# Imagen base oficial de MySQL
FROM mysql:8.0

# Password root (sobrescrito por .env en compose)
ENV MYSQL_ROOT_PASSWORD=root

# Si quieres inicializar con SQL propio, coloca .sql en ./init
# COPY ./init/ /docker-entrypoint-initdb.d/

EXPOSE 3306
