# Probar la API con curl

A continuación, algunos comandos de ejemplo para verificar que la API funciona correctamente. Se recomienda tener instalado `jq` para visualizar las respuestas JSON de forma legible:

> ⚠️ Nota: Recordá reemplazar `<token>` con el token JWT real recibido en el login o registro.

--- 

## Índice

- [Requisitos previos](#requisitos-previos)
- [Registrar nuevo usuario](#registrar-nuevo-usuario)
- [Iniciar sesión](#iniciar-sesión)
- [Obtener información del usuario autenticado](#obtener-información-del-usuario-autenticado)
- [Listar usuarios](#listar-usuarios)
- [Cerrar sesión](#cerrar-sesión)
- [Listar todos los parkings registrados (paginados)](#listar-todos-los-parkings-registrados-paginados)
- [Crear un nuevo parking](#crear-un-nuevo-parking)
- [Consultar un parking por ID](#consultar-un-parking-por-id)
- [Buscar parking cercano](#buscar-parking-cercano) 
- [Consultar logs de accesos mayores a 500 metros](#consultar-logs-de-accesos-mayores-a-500-metros)

--- 
  
## Requisitos previos

Antes de comenzar, asegurate de tener instalados:

- **curl:** herramienta de línea de comandos para realizar solicitudes HTTP.
- **jq:** utilidad para procesar y visualizar respuestas JSON de forma legible.

Podés instalarlos en Ubuntu con:
```bash
sudo apt update && sudo apt install -y curl jq
```

Podés verificar si están instalados ejecutando:

```bash
curl --version
jq --version
```

--- 

### Registrar nuevo usuario

```bash 
curl -s -X POST http://localhost:8080/api/register \
-H "Content-Type: application/json" \
-d '{"name":"usuario test", "email":"email.02@gmail.com", "password":"email.02@gmail.com"}'  | jq
```

Respuesta esperada:

```json
{
  "status": true,
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvYXBpL3JlZ2lzdGVyIiwiaWF0IjoxNzU0MTI3NDkzLCJleHAiOjE3NTQxMzEwOTMsIm5iZiI6MTc1NDEyNzQ5MywianRpIjoiaVhGT2N4UkJjZGpyTXNIZCIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.7xCaSeqbxZT7utrTF32GoIjnJ1SE-BlkDzlUzQimxgI"
}
```

--- 

### Iniciar sesión

```bash 
curl -s -X POST http://localhost:8080/api/login \
-H "Content-Type: application/json" \
-d '{"email":"email.02@gmail.com", "password":"email.02@gmail.com"}' | jq
```

Respuesta esperada:

```json
{
  "status": true,
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvYXBpL2xvZ2luIiwiaWF0IjoxNzU0MTI3NTU2LCJleHAiOjE3NTQxMzExNTYsIm5iZiI6MTc1NDEyNzU1NiwianRpIjoiZXlkbENsc1JrTjFESUJnMiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.jAxf9yZ-Xy1IOGMZiQx5nXhNdQ2Mn6laC6Dz0r6ZuDA"
}
```
--- 

### Obtener información del usuario autenticado 
```bash 
curl -s -X GET http://localhost:8080/api/me \
-H "Authorization: Bearer <token>" \
-H "Content-Type: application/json" | jq
```

Respuesta esperada:

```json
{
  "status": true,
  "data": {
    "id": 1,
    "name": "usuario test",
    "email": "email.02@gmail.com",
    "created_at": "2025-08-02T09:38:13.000000Z",
    "updated_at": "2025-08-02T09:38:13.000000Z"
  }
}
```
--- 

### Listar usuarios 

```bash 
curl -s -X GET http://localhost:8080/api/users \
-H "Authorization: Bearer <token>" \
-H "Content-Type: application/json" | jq
```

Respuesta esperada:

```json
{
  "status": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 2,
        "name": "usuario test",
        "email": "email.02@gmail.com",
        "email_verified_at": null,
        "created_at": "2025-08-02T04:03:18.000000Z",
        "updated_at": "2025-08-02T04:03:18.000000Z"
      },
      {
        "id": 1,
        "name": "usuario test",
        "email": "email.01@gmail.com",
        "email_verified_at": null,
        "created_at": "2025-08-02T03:55:36.000000Z",
        "updated_at": "2025-08-02T03:55:36.000000Z"
      }
    ],
    "first_page_url": "http://localhost:8080/api/users?page=1",
    "from": 1,
    "next_page_url": null,
    "path": "http://localhost:8080/api/users",
    "per_page": 10,
    "prev_page_url": null,
    "to": 2
  }
}
```
--- 

### Cerrar sesión

```bash 
curl -s -X POST http://localhost:8080/api/logout \
-H "Authorization: Bearer <token>" \
-H "Content-Type: application/json" | jq
```

Respuesta esperada:

```json
{
  "status": true,
  "message": "Successfully logged out"
}
```

--- 

### Listar todos los parkings registrados (paginados)

Este endpoint devuelve un listado paginado de todos los parkings registrados en el sistema.

```bash
curl -s http://localhost:8080/api/parkings \
-H "Authorization: Bearer <token>" \
-H "Content-Type: application/json" | jq
```

Respuesta esperada:
    
```json
{
    "status": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 2,
                "nombre": "Calle Rivadavia y San Juan",
                "direccion": "Calle Rivadavia y San Juan",
                "latitud": "-26.8261960",
                "longitud": "-65.2005120",
                "created_at": "2025-08-01T23:23:08.000000Z",
                "updated_at": "2025-08-01T23:23:08.000000Z"
            },
            {
                "id": 1,
                "nombre": "Calle Rivadavia y Santiago",
                "direccion": "Calle Rivadavia y Santiago",
                "latitud": "-26.8248300",
                "longitud": "-65.2001600",
                "created_at": "2025-08-01T23:23:08.000000Z",
                "updated_at": "2025-08-01T23:23:08.000000Z"
            }
        ],
        "first_page_url": "http://localhost:8080/api/parkings?page=1",
        "from": 1,
        "next_page_url": null,
        "path": "http://localhost:8080/api/parkings",
        "per_page": 10,
        "prev_page_url": null,
        "to": 6
    }
}
```
--- 

### Crear un nuevo parking

```bash 
curl -s -X POST http://localhost:8080/api/parkings \
-H "Content-Type: application/json" \
-H "Authorization: Bearer <token>" \
-d '{"nombre":"Parking Rivadavia", "direccion":"Calle Rivadavia 123", "latitud":-26.8148, "longitud":-65.2163}' | jq
```

Respuesta esperada:

```json
{
    "status": true,
    "message": "Parking creado correctamente",
    "data": {
        "nombre": "Parking Rivadavia",
        "direccion": "Calle Rivadavia 123",
        "latitud": -26.8148,
        "longitud": -65.2163,
        "updated_at": "2025-08-01T23:59:57.000000Z",
        "created_at": "2025-08-01T23:59:57.000000Z",
        "id": 7
    }
}
```

--- 

### Consultar un parking por ID

```bash 
curl -s "http://localhost:8080/api/parkings/1" \
-H "Content-Type: application/json" \
-H "Authorization: Bearer <token>" | jq
```

Respuesta esperada:

```json
{
    "status": true,
    "data": {
        "id": 1,
        "nombre": "Calle Rivadavia y Santiago",
        "direccion": "Calle Rivadavia y Santiago",
        "latitud": "-26.8248300",
        "longitud": "-65.2001600",
        "created_at": "2025-08-01T23:23:08.000000Z",
        "updated_at": "2025-08-01T23:23:08.000000Z"
    }
}
```

--- 

### Buscar parking cercano

```bash 
curl -s -X GET "http://localhost:8080/api/buscar-cercano?lat=-26.74721&lon=-65.24686" \
-H "Content-Type: application/json" \
-H "Authorization: Bearer <token>" | jq
```
Respuesta esperada:

```json
{
    "status": true,
    "data": {
        "id": 7,
        "nombre": "Parking Rivadavia",
        "direccion": "Calle Rivadavia 123",
        "latitud": "-26.8148000",
        "longitud": "-65.2163000",
        "created_at": "2025-08-01 23:59:57",
        "updated_at": "2025-08-01 23:59:57",
        "distancia": "8.105"
    }
}
```

--- 

### Consultar logs de accesos mayores a 500 metros

```bash
curl -s -X GET "http://localhost:8080/api/logs/distantes" \
-H "Content-Type: application/json" \
-H "Authorization: Bearer <token>" | jq
```

Respuesta esperada:

```json
{
    "status": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "latitud": "-26.7472100",
                "longitud": "-65.2468600",
                "distancia": "8.105",
                "parking_nombre": "Parking Rivadavia",
                "created_at": "2025-08-02T00:04:54.000000Z",
                "updated_at": "2025-08-02T00:04:54.000000Z"
            }
        ],
        "first_page_url": "http://localhost:8080/api/logs/distantes?page=1",
        "from": 1,
        "next_page_url": null,
        "path": "http://localhost:8080/api/logs/distantes",
        "per_page": 10,
        "prev_page_url": null,
        "to": 1
    }
}
```
--- 