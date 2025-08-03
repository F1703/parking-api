# Documentación para levantar el entorno local del proyecto Laravel con Docker

Este proyecto Laravel utiliza **Docker** para facilitar la ejecución del entorno de desarrollo, eliminando la necesidad de instalar manualmente servicios como **PHP**, **PostgreSQL** y **Nginx** en tu sistema operativo.

Además, se integran las siguientes tecnologías clave:

- **Laravel 10**: Framework PHP moderno y robusto para construir APIs RESTful.
- **PHP 8.3**: Versión estable y actual del lenguaje PHP.
- **PostgreSQL 17**: Base de datos relacional potente y confiable.
- **JWT (JSON Web Tokens)**: Para autenticación segura y stateless de usuarios.
- **Swagger (OpenAPI)**: Documentación interactiva de los endpoints de la API.
- **L5-Swagger**: Paquete Laravel para generar documentación Swagger automáticamente.
- **Nginx**: Servidor web para manejar el tráfico HTTP hacia la aplicación.
- **Docker Compose**: Orquestador de contenedores para levantar todos los servicios con un solo comando.
- **Larastan (PHPStan para Laravel)**: Para análisis estático y detección temprana de errores y código no utilizado.

---

## Índice

- [Requisitos previos](#requisitos-previos)
- [Estructura del proyecto](#estructura-del-proyecto)
- [Levantar el entorno local](#levantar-el-entorno-local)
- [Acceso a la aplicación y la documentación interactiva de la API](#acceso-a-la-aplicación-y-la-documentación-interactiva-de-la-api)
- [Probar la API con Postman (ver guía separada)](./readme_postman.md)
- [Probar la API con curl (ver guía separada)](./readme_curl.md)
- [Comandos útiles](#comandos-útiles)

--- 

## Requisitos previos

Antes de comenzar, asegurate de tener instalados:

- [Docker y Docker Compose (ver guía separada)](./readme_instalacion-docker-ubuntu.md) 

Podés verificar si están instalados ejecutando:

```bash
sudo docker -v
sudo docker compose version
```

## Estructura del proyecto

```
.
├── .github
│   ├── workflows
│   │   └── larastan.yml
├── docker
│   ├── nginx
│   │   └── default.conf
│   └── php
│       └── entrypoint.sh
│       └── php.ini-development
│       └── php.ini-production
│       └── www.conf
├── postman
│   └── postman_collection.json
├── src
│   └── ... código fuente Laravel 10...
├── docker-compose.yml
├── Dockerfile
```

## Levantar el entorno local

1 )  Clonar el repositorio:

```bash
git clone htts://github.com/F1703/parking-api.git
cd parking-api
```

2 ) Construir y levantar los contenedores: 
 
```bash
sudo docker compose up -d --build
```

Esto levantará los siguientes servicios:

- **app**: PHP 8.3 + Laravel
- **db**: PostgreSQL 17
- **nginx**: Servidor web accesible desde `http://localhost:8080`

3 ) ¡Listo! 

El proyecto ya contiene el archivo `.env` configurado y las dependencias se instalan automáticamente en el build. También se aplican las migraciones al iniciar el contenedor.

---

## Acceso a la aplicación y la documentación interactiva de la API

1 ) Aplicación y endpoints de la API:\
  `http://localhost:8080`

2 ) Interfaz de prueba interactiva para la API (documentación generada automáticamente):\
  `http://localhost:8080/api/documentation`

- Esta documentación fue generada usando Swagger y permite ver todos los endpoints disponibles, sus parámetros, posibles respuestas, e incluso probarlos directamente desde el navegador.

---
 
## [Probar la API con Postman (ver guía separada)](./readme_postman.md)

 
## [Probar la API con curl (ver guía separada)](./readme_curl.md)

 
## Comandos útiles

**Si necesitás trabajar dentro del contenedor:**

```bash
sudo docker exec -it laravel_app bash
```

Limpiar cachés de Laravel:

```bash
php artisan config:clear
php artisan route:clear
php artisan cache:clear
```

Generar keygen:

```bash
php artisan key:generate
```

Ejecutar migraciones con seeder:

```bash
php artisan migrate:refresh --force --seed
```


**Fuera del contenedor:**

> ⚠️ Los comandos siguientes en caso de utilizarlos deben ejecutarse desde el directorio raíz del proyecto, donde se encuentra el archivo ```.docker-compose.yml``` 
        
Ver logs de todos los servicios:

```bash
sudo docker compose logs -f
```

Ver Logs de PHP/Laravel:

```bash
sudo docker compose logs -f app
```

Ver Logs del servidor web:

```bash
sudo docker compose logs -f nginx
```

Ver Logs del servidor PostgreSQL:

```bash
sudo docker compose logs -f db
```

Apagar los contenedores:

```bash
sudo docker compose down -v
```

Detener los contenedores y eliminar volúmenes de datos y contenedores huérfanos:

```bash
sudo docker compose down -v --remove-orphans
```


Construir y levantar los contenedores

```bash
sudo docker compose up -d --build
```
--- 