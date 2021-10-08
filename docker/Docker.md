# Uso de docker

Estas son algunas maneras para ejecutar este proyecto en un entorno de *Docker*.

## Estrategia de uso creando la imagen en forma local

1. [Construir la imagen](#construcción-de-la-imagen)

## Estrategia de uso publicando la imagen en dockerhub

Importante: esta estrategia está pendiente, pero de esta forma se tendría
una imagen pública siempre disponible y actualizada con la última versión.
Sin necesidad de construir y mantener la imagen localmente.

1. Construir la imagen.
2. Publicar la imagen en dockerhub.
3. Automatizar el proceso de creación de imágenes con base en tag releases.
4. Incluir un proceso automático de actualización de dependencias (dependabot).

## Construcción de la imagen

Comandos relacionados con la construcción de la imagen local.

```shell
# construir la imagen (usar --no-cache para forzar la reconstrucción)
docker build -t api-descarga-masiva -f docker/Dockerfile .

# eliminar la imagen
docker rmi api-descarga-masiva
```

Comandos relacionados con la construcción del contenedor.

En el ejemplo se publicará la aplicación en `http://localhost:8081/` y los datos estarán
almacenados en la carpeta `$HOME/api-descarga-masiva-data`

```shell
# ejecutar un contenedor en el fondo con puertos y datos
docker run --name=api-descarga-masiva \
  --detach=true \
  --publish 8081:80 \
  --volume $HOME/api-descarga-masiva-data:/opt/api-descarga-masiva/storage/app/datos/ \
  api-descarga-masiva

# iniciar y detener el contenedor
docker stop api-descarga-masiva
docker start api-descarga-masiva

# entrar con una sesión de bash
docker exec -it api-descarga-masiva /bin/bash

# eliminar el contenedor
docker rm api-descarga-masiva

# ejecutar un contenedor y eliminarlo
docker run --rm \
  --publish 8081:80 \
  --volume $HOME/api-descarga-masiva-data:/opt/api-descarga-masiva/storage/app/datos/ \
  api-descarga-masiva
```

## Laravel-way

Las aplicaciones de Laravel acostumbran utilizar `sail` como virtualización del entorno de desarrollo y ejecución.
Vea la documentación de [`laravel/sail`](https://laravel.com/docs/8.x/sail) para usar este proyecto de esta forma.