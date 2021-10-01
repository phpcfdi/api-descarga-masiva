# Contribuciones

Las contribuciones son bienvenidas, te invitamos a enviarlas a través de un *pull request*, un *issue*
o una *discusión* de GitHub. Te pedimos que sigas esta guía en caso de enviar un *pull request*.

## Proceso

1. Haz un *fork* del proyecto.
1. Crea una nueva rama.
1. Haz tu código, corre las pruebas y comparte tus cambios.
1. En el *pull request* detalla los cambios.

## Guía básica

* Apégate al estándar de código del proyecto.
* Asegúrate que las pruebas actuales son exitosas. Si has agregado algo crea las pruebas oportunas.
* Envía una historia de *commits* coherente, haz que cada *commit* en tu *pull request* tenga sentido.
* Tal vez necesites hacer *[rebase](https://git-scm.com/book/en/v2/Git-Branching-Rebasing)* para evitar *merge conflicts*.
* Si estás cambiando el comportamiento o la API pública entonces cambia también la documentación.
* Corre las revisiones en tu entorno de desarrollo antes de enviar tu *pull request*, asegúrate que tus pruebas son exitosas.

## Revisiones de integración continua (CI)

Este proyecto usa *GitHub Workflows* para el proceso de integración continua *(CI: Continuous Integration)*.

El proceso de CI se ejecuta con todas las versiones de PHP con las que el proyecto es compatible.

Si planeas enviar un *pull request* asegúrate que las revisiones del proceso de CI se ejecutan sin errores.
Las revisiones las puedes ejecutar en tu entorno de desarrollo, sigue los comandos descritos en:
*Estilo*, *Pruebas* y *Análisis estático*.

### Estilo

Apégate al estándar de código del proyecto, verificado usando [PHPInsights][].

Para corregir el código automáticamente:

```shell
php artisan insights --fix --no-interaction
```

Para revisar el código que no sigue el estándar:

```shell
php artisan insights --no-interaction
```

### Pruebas

El proyecto tiene diferentes tipos de pruebas, usamos [PHPUnit][] para escribirlas.

```shell
php artisan test
```

### Análisis estático

El análisis estático de código puede ser muy útil para detectar errores y código defectuoso.
Este proyecto usa [PHPStan][] a través de [Larastan][].

```shell
php vendor/bin/phpstan analyse -v
```

## Otras herramientas

### Simulación de GitHub Actions

Con la herramienta [nektos/act][] se puede simular todos los flujos de trabajo en tu máquina si tienes [Docker][] instalado.

```shell
act -P ubuntu-latest=shivammathur/node:latest
```

## `rector/rector`

[Rector][] permite automatizar la modificación de código, se agregó al proyecto para hacer las modificaciones
automáticas de PHP 7.3 a PHP 7.4. No está agregado a proceso de CI porque no es necesaria su ejecución continua.

```shell
php vendor/bin/rector process --dry-run
```

[PHPInsights]: https://phpinsights.com/
[PHPUnit]: https://phpunit.de/
[PHPStan]: https://github.com/phpstan/phpstan
[Larastan]: https://github.com/nunomaduro/larastan
[nektos/act]: https://github.com/nektos/act
[Docker]: https://docs.docker.com/
[Rector]: https://github.com/rectorphp/rector
