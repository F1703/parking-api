# Instalación de Docker y Docker Compose en Ubuntu

Esta guía te mostrará cómo instalar Docker y Docker Compose en Ubuntu (válido para Ubuntu 20.04, 22.04 y versiones similares), para que puedas ejecutar aplicaciones en contenedores de manera sencilla.

---

## Requisitos previos

- Sistema operativo: Ubuntu 20.04, 22.04 o superior.
- Usuario con permisos de `sudo`.
- Conexión a Internet.

---

## 1. Actualizar el sistema

Actualiza la lista de paquetes y el sistema a la última versión:

```bash
sudo apt update
sudo apt upgrade -y
```


## 3. Añadir la clave GPG oficial de Docker
Esto garantiza la seguridad y autenticidad de los paquetes Docker:

```bash
sudo mkdir -p /etc/apt/keyrings

curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
```


## 4. Añadir el repositorio oficial de Docker
Agrega el repositorio oficial para descargar Docker:

```bash
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
  $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
```


## 5. Instalar Docker Engine y Docker Compose
Actualiza la lista de paquetes y luego instala Docker Engine, CLI, containerd y Docker Compose plugin:

```bash
sudo apt update -y 

sudo apt install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

```


## 6. Verificar la instalación de Docker
Verifica que Docker esté correctamente instalado con:

```bash
sudo docker --version
```

Deberías ver un mensaje como:

```bash
Docker version 24.x.x, build xxxx
```



## 7. Verificar la instalación de Docker Compose
Docker Compose está incluido como plugin en las versiones recientes. Verifícalo con:

```bash
sudo docker compose version
```
Deberías ver algo similar a:
```bash
Docker Compose version v2.x.x
``` 

## 8. Ejecutar Docker sin sudo (opcional)
Para evitar escribir sudo cada vez que usas Docker, agrega tu usuario al grupo docker:

```bash
sudo usermod -aG docker $USER
```



## 9. Probar Docker con un contenedor de prueba
Ejecuta el contenedor oficial de prueba para comprobar que Docker funciona bien:

```bash
sudo docker run hello-world
```



# Recursos adicionales

- [Documentación oficial de Docker para Ubuntu](https://docs.docker.com/engine/install/ubuntu/)
- [Documentación oficial de Docker Compose](https://docs.docker.com/compose/install/) 






