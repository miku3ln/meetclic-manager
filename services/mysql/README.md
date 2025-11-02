# README – Stack MySQL + phpMyAdmin + Nginx (proxy HTTP y TCP)

> **Guía express e ilustrativa (TL;DR)**
>
> 1. **Arranca/recicla contenedores**
>
> ```bash
> docker compose down
> docker compose up -d
> docker compose ps
> ```
>
> 2. **Entra a phpMyAdmin** → **[http://localhost:8081/pma/](http://localhost:8081/pma/)**
     >    Usuario: `PMA_USER` (por defecto `root`) · Clave: `MYSQL_ROOT_PASSWORD`
     >    *Si estás en otra máquina:* `http://<IP-o-dominio>:8081/pma/`
>
> 3. **Importa tu .sql** (UI de phpMyAdmin o CLI):
>
> ```bash
> # Alternativa CLI (recomendada para dumps grandes)
> # vía proxy Nginx (3308)
> mysql -h 127.0.0.1 -P 3308 -u root -p appdb < /ruta/tu_dump.sql
>
> # o directo al contenedor MySQL (3307)
> mysql -h 127.0.0.1 -P 3307 -u root -p appdb < /ruta/tu_dump.sql
> ```
>
> 4. **Problemas comunes**
>
> * **504 Gateway Time‑out al importar** → ya viene mitigado en `nginx.conf` (timeouts y `client_max_body_size`) y en `php-custom.ini` (límites PHP).
> * **`Packet too large`** → `--max_allowed_packet=256M` ya está añadido en MySQL.

---

Este servicio levanta un entorno de base de datos MySQL 8 con:

* **MySQL** (contenedor `db_mysql`).
* **phpMyAdmin** para administración web (contenedor `phpmyadmin`).
* **Nginx** actuando como **reverse proxy HTTP** hacia phpMyAdmin y **TCP stream proxy** hacia MySQL.
* **Volumen persistente** para datos (`db_data`).
* **Network** aislada (`mysql_stack_net`).

La configuración permite:

* **Acceso web a phpMyAdmin** en la subruta `/pma` por el puerto **8081** del host.
* **Acceso MySQL vía Nginx (proxy TCP)** por el puerto **3308** del host.
* **Acceso MySQL directo al contenedor** por el puerto **3307** del host (opcional, útil para depuración local).

---

## 1) Estructura de archivos

```
.
├─ docker-compose.yml
├─ Dockerfile                # Imagen MySQL 8 (opcional si no usas la oficial tal cual)
├─ nginx.conf                # Proxy HTTP (/pma) y TCP stream (3308)
├─ .env                      # Variables de entorno (puertos, credenciales, TZ, etc.)
└─ init/                     # (opcional) SQL de inicialización montado a /docker-entrypoint-initdb.d/
```

---

## 2) nginx.conf (explicación)

```nginx
worker_processes auto;

events { worker_connections 1024; }

# ---------- TCP STREAM PARA MYSQL ----------
stream {
    upstream mysql_backend {
        server db:3306;   # resuelve al servicio "db" en la network de Docker
    }

    server {
        listen 3308;                  # expone este puerto dentro del contenedor Nginx
        proxy_connect_timeout 10s;
        proxy_timeout 1h;
        proxy_pass mysql_backend;     # reenvía tráficos TCP a MySQL
    }
}

# ---------- HTTP PARA PHPMYADMIN ----------
http {
    include       mime.types;
    default_type  application/octet-stream;
    sendfile      on;
    keepalive_timeout  65;

    server {
        listen 80;
        server_name _;

        # Proxy hacia phpMyAdmin en subruta /pma
        location /pma/ {
            proxy_http_version 1.1;
            rewrite ^/pma/?(.*)$ /$1 break;   # quita el prefijo /pma antes de pasar al backend

            proxy_set_header Host              $host;
            proxy_set_header X-Real-IP         $remote_addr;
            proxy_set_header X-Forwarded-For   $proxy_add_x_forwarded_for;
            proxy_set_header X-Forwarded-Proto $scheme;

            proxy_pass http://phpmyadmin:80/;  # servicio docker "phpmyadmin"
        }

        access_log /var/log/nginx/access.log;
        error_log  /var/log/nginx/error.log;
    }
}
```

**Qué hace cada bloque:**

* **stream { … }**: habilita a Nginx como proxy TCP hacia MySQL.
* **upstream mysql\_backend**: apunta al servicio Docker `db` (puerto 3306 interno).
* **server listen 3308**: Nginx escucha internamente en 3308 para reenviar a MySQL, y se publica al host vía `ports` en `docker-compose.yml`.
* **location /pma/**: define la subruta pública para phpMyAdmin. La regla `rewrite` elimina el prefijo `/pma` antes de pasar la solicitud al contenedor `phpmyadmin`.

> **Nota**: En algunos casos phpMyAdmin detrás de subrutas requiere definir `PMA_ABSOLUTE_URI`. Este README incluye cómo activarlo (ver §6 Ajustes y personalizaciones).

---

## 3) Dockerfile (MySQL 8)

```dockerfile
# Imagen base oficial de MySQL
FROM mysql:8.0

# Password root (sobrescrito por .env en compose)
ENV MYSQL_ROOT_PASSWORD=root

# Si quieres inicializar con SQL propio, coloca .sql en ./init
# COPY ./init/ /docker-entrypoint-initdb.d/

EXPOSE 3306
```

* Usa la imagen oficial **mysql:8.0**.
* El `ENV MYSQL_ROOT_PASSWORD` es un fallback; **se sobreescribe** por las variables del `docker-compose.yml`/`.env`.
* Los `*.sql` en `./init` se ejecutan automáticamente en el primer arranque si montas esa carpeta (útil para crear DBs, tablas, usuarios).

---

## 4) docker-compose.yml (explicación servicio por servicio)

### Servicios

#### `db` (MySQL)

* Construye desde `Dockerfile` (o podrías usar directamente `image: mysql:8.0`).
* Variables de entorno controladas por **.env**: `MYSQL_ROOT_PASSWORD`, `MYSQL_ROOT_HOST`, `MYSQL_DATABASE`, `TZ`.
* **command**: fuerza el plugin de autenticación legado `mysql_native_password` (útil para ciertas librerías/ORM antiguos).
* **ports**: publica el puerto **3307:3306** para acceso directo (opcional, debug local).
* **volumes**: `db_data:/var/lib/mysql` asegura **persistencia** de datos.
* **healthcheck**: espera a que MySQL responda para que otros servicios dependan de su estado.

#### `phpmyadmin`

* Imagen oficial `phpmyadmin:5`.
* Variables: `PMA_HOST=db`, `PMA_PORT=3306`, credenciales (usuario/clave) y `UPLOAD_LIMIT`.
* `depends_on`: espera a que MySQL esté **healthy**.
* **No expone puertos directamente**; se accede por Nginx en `/pma`.

#### `nginx`

* Imagen `nginx:latest`.
* Monta `./nginx.conf` **solo lectura** en `/etc/nginx/nginx.conf`.
* Depende de `db` y `phpmyadmin`.
* **ports**:

    * `${NGINX_HTTP_PUBLISH}` → publica **8081:80** (HTTP a phpMyAdmin en subruta `/pma`).
    * `${NGINX_MYSQL_PUBLISH}` → publica **3308:3308** (TCP proxy a MySQL).

#### Networks / Volúmenes

* **default network**: `mysql_stack_net` para que los servicios se resuelvan por nombre.
* **volumen** `db_data`: persistencia de MySQL.

---

## 5) .env (variables y significado)

Ejemplo provisto:

```dotenv
# --- Publicación de puertos ---
# phpMyAdmin vía Nginx (HTTP proxy)
NGINX_HTTP_PUBLISH=8081:80

# MySQL vía Nginx (TCP stream)
NGINX_MYSQL_PUBLISH=3308:3308

# MySQL directo al contenedor (opcional, útil para depuración)
MYSQL_DIRECT_PUBLISH=3307:3306

# --- Credenciales ---
MYSQL_ROOT_PASSWORD=root
MYSQL_ROOT_HOST=%      # root accesible desde cualquier host (solo dev)
MYSQL_DATABASE=appdb

# --- phpMyAdmin ---
PMA_UPLOAD_LIMIT=256M
PMA_USER=root

# --- Zona horaria ---
TZ=America/Guayaquil
```

| Variable               | ¿Para qué sirve?                                                                  | Valor ejemplo       |
| ---------------------- | --------------------------------------------------------------------------------- | ------------------- |
| `NGINX_HTTP_PUBLISH`   | Publica HTTP del Nginx hacia el host. Primer puerto = host, segundo = contenedor. | `8081:80`           |
| `NGINX_MYSQL_PUBLISH`  | Publica el TCP stream de Nginx para MySQL.                                        | `3308:3308`         |
| `MYSQL_DIRECT_PUBLISH` | Publica MySQL directo (bypass Nginx) para depuración.                             | `3307:3306`         |
| `MYSQL_ROOT_PASSWORD`  | Clave del usuario `root`.                                                         | `root`              |
| `MYSQL_ROOT_HOST`      | Hosts desde los que `root` puede conectar (`%` = cualquiera). **Solo dev**.       | `%`                 |
| `MYSQL_DATABASE`       | Crea una DB inicial con ese nombre.                                               | `appdb`             |
| `PMA_UPLOAD_LIMIT`     | Límite de subida de archivos en phpMyAdmin.                                       | `256M`              |
| `PMA_USER`             | Usuario por defecto en formulario de login de phpMyAdmin.                         | `root`              |
| `TZ`                   | Zona horaria del contenedor MySQL.                                                | `America/Guayaquil` |

> **Seguridad:** Usa `MYSQL_ROOT_HOST=%` solo en **desarrollo**. En producción, restringe a IPs específicas o evita exponer root.

---

## 6) Puesta en marcha

1. **Requisitos:** Docker y Docker Compose instalados; puertos 8081/3308/3307 libres.
2. Crea/corrige tu archivo **.env** con los valores deseados.
3. Levanta el stack:

   ```bash
   docker compose up -d --build
   ```
4. Verifica contenedores:

   ```bash
   docker ps
   ```
5. Revisa salud de MySQL (debe estar `healthy`):

   ```bash
   docker inspect --format='{{json .State.Health}}' db_mysql | jq
   ```

---

## 7) Accesos rápidos

### phpMyAdmin (vía Nginx)

* Navega a: **[http://localhost:8081/pma/](http://localhost:8081/pma/)**
* Si es otro host: `http://<IP-o-dominio>:8081/pma/`
* Usuario: `PMA_USER` (por defecto `root`)
  Password: `MYSQL_ROOT_PASSWORD`

> Si tuvieras problemas de subruta, agrega la variable de entorno en `phpmyadmin`:
>
> ```yaml
> environment:
>   PMA_ABSOLUTE_URI: "http://<host>:8081/pma/"
> ```

### MySQL (vía Nginx TCP stream)

* Host: `127.0.0.1`
* Puerto: **3308**
* Usuario: `root` (o el que crees)
* Ejemplo CLI:

  ```bash
  mysql -h 127.0.0.1 -P 3308 -u root -p
  ```

### MySQL (directo al contenedor)

* Host: `127.0.0.1`
* Puerto: **3307**
* Útil cuando quieres evitar el proxy o depurar.

---

## 8) Operación común

### Crear base y usuario propio (recomendado)

```sql
CREATE DATABASE IF NOT EXISTS appdb CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
CREATE USER 'appuser'@'%' IDENTIFIED BY 'cambiame_seguro';
GRANT ALL PRIVILEGES ON appdb.* TO 'appuser'@'%';
FLUSH PRIVILEGES;
```

> Ajusta `@'%'` a rangos/hosts más estrictos en producción.

### Backups y restores

**Backup:**

```bash
docker exec -i db_mysql mysqldump -u root -p"$MYSQL_ROOT_PASSWORD" --databases appdb > backup_appdb_$(date +%F).sql
```

**Restore:**

```bash
mysql -h 127.0.0.1 -P 3308 -u root -p appdb < backup_appdb_2025-09-18.sql
# o directo al contenedor
mysql -h 127.0.0.1 -P 3307 -u root -p appdb < backup_appdb_2025-09-18.sql
```

### Logs útiles

```bash
# Nginx
docker logs -f nginx_gateway

# phpMyAdmin
docker logs -f phpmyadmin

# MySQL
docker logs -f db_mysql
```

---

## 9) Ajustes y personalizaciones

### Charset y collation por defecto

Para evitar errores tipo **Illegal mix of collations**, define charset/collation del servidor o de la DB/tablas:

**Opción A – por comando en compose:**

```yaml
services:
  db:
    command:
      - "--default-authentication-plugin=mysql_native_password"
      - "--character-set-server=utf8mb4"
      - "--collation-server=utf8mb4_general_ci"   # o utf8mb4_0900_ai_ci en MySQL 8
```

**Opción B – al crear la base:**

```sql
CREATE DATABASE appdb CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

> Procura que **cliente, base y tablas** usen el mismo charset/collation.

### Limitar exposición de puertos

* Si solo accederás localmente, publica puertos así para evitar exposición externa:

  ```dotenv
  NGINX_HTTP_PUBLISH=127.0.0.1:8081:80
  NGINX_MYSQL_PUBLISH=127.0.0.1:3308:3308
  MYSQL_DIRECT_PUBLISH=127.0.0.1:3307:3306
  ```

### Forzar subruta estable en phpMyAdmin

* Si ves redirecciones raras de assets, añade:

  ```yaml
  phpmyadmin:
    environment:
      PMA_ABSOLUTE_URI: "http://<host>:8081/pma/"
  ```

### Proteger `/pma` en producción

* Habilita **Auth Básica** en Nginx o restricción por IP.
* Considera colocar Nginx detrás de un **reverse proxy con TLS** (Caddy/Traefik/Nginx con certificados). Si quieres TLS nativo aquí, agrega un `server` 443 con certificados y `proxy_pass` igual.

---

## 10) Solución de problemas (Troubleshooting)

* **No carga `http://localhost:8081/pma/`:**

    1. ¿Stack arriba? `docker compose ps`
    2. ¿MySQL healthy? `docker ps` (columna STATUS)
    3. ¿Puerto 8081 libre? Cambia en `.env` o libera el puerto.
    4. Revisa `docker logs nginx_gateway` y `docker logs phpmyadmin`.

* **502/504 en `/pma`:** phpMyAdmin no alcanzable o MySQL down. Revisa salud de `db_mysql` y logs.

* **No conecta a 3308:** Nginx no está publicando el puerto o firewall lo bloquea. Verifica `NGINX_MYSQL_PUBLISH` y reglas.

* **`Access denied for user 'root'@'…'`:** `MYSQL_ROOT_HOST` demasiado restrictivo. En dev puedes usar `%`; en prod, crea usuarios por app.

* **Errores de collation/charset:** Alinea `--character-set-server` y `--collation-server`, y crea la DB con `utf8mb4`.

* **Uploads grandes fallan en phpMyAdmin:** Sube `PMA_UPLOAD_LIMIT` y ajusta `client_max_body_size` en Nginx si usas archivos muy grandes:

  ```nginx
  http {
    client_max_body_size 256m;  # acorde a tu .env
    ...
  }
  ```

---

## 11) Diagrama (alto nivel)

```
[Cliente Web] --HTTP--> [Nginx :8081] --/pma--> [phpMyAdmin :80] --TCP--> [MySQL :3306]

[Cliente MySQL] --TCP--> [Nginx :3308] --proxy stream--> [MySQL :3306]
[Cliente MySQL] --TCP--> [Host :3307]  --(directo)-->       [MySQL :3306]
```

---

## 12) Comandos útiles

```bash
# Levantar / parar / reiniciar
docker compose up -d --build
docker compose stop
docker compose down

# Entrar al contenedor MySQL y shell
docker exec -it db_mysql bash
mysql -u root -p

# Crear dump de todas las bases
docker exec -i db_mysql mysqldump -u root -p"$MYSQL_ROOT_PASSWORD" --all-databases > all_$(date +%F).sql

# Restaurar (todas las bases)
mysql -h 127.0.0.1 -P 3308 -u root -p < all_2025-09-18.sql
```

---

## 13) Buenas prácticas para producción (resumen)

* **No** uses `root` en apps; crea usuarios con privilegios mínimos.
* Cambia **passwords** y **limita hosts** (`MYSQL_ROOT_HOST` y GRANTs específicos).
* Publica puertos en `127.0.0.1` y expón solo detrás de un proxy con **TLS**.
* Protege `/pma` con **Auth** o restricción por IP; considera deshabilitarlo fuera de mantenimiento.
* Configura **backups** automáticos y monitoreo de salud.
* Establece **charset/collation** uniformes (`utf8mb4`).

---

## 14) Créditos

* Imágenes oficiales: `mysql:8.0`, `phpmyadmin:5`, `nginx:latest`.
* Este stack está pensado para **desarrollo** y puede adaptarse a producción endureciendo seguridad y TLS.
