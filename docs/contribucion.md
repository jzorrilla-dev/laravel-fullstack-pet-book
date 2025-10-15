# Guía de Contribución

Este documento describe cómo contribuir al proyecto PetBook.

## Proceso de Contribución

1. **Fork del Repositorio**
   - Crea un fork del repositorio en tu cuenta de GitHub

2. **Clonar el Repositorio**
   - Clona tu fork a tu máquina local
   - `git clone https://github.com/tu-usuario/laravel-fullstack-pet-book.git`

3. **Crear una Rama**
   - Crea una rama para tu contribución
   - `git checkout -b feature/nombre-de-la-funcionalidad`

4. **Realizar Cambios**
   - Implementa tus cambios siguiendo las convenciones de código
   - Asegúrate de que el código pase las pruebas

5. **Commit y Push**
   - Haz commit de tus cambios con mensajes descriptivos
   - `git commit -m "Descripción clara del cambio"`
   - Sube los cambios a tu fork
   - `git push origin feature/nombre-de-la-funcionalidad`

6. **Crear Pull Request**
   - Crea un Pull Request desde tu rama a la rama principal del repositorio original
   - Describe claramente los cambios realizados

## Convenciones de Código

- Sigue las [convenciones de Laravel](https://laravel.com/docs/10.x/contributions#coding-style)
- Utiliza nombres descriptivos para variables, funciones y clases
- Escribe comentarios claros para código complejo
- Mantén las funciones pequeñas y con una única responsabilidad

## Pruebas

- Asegúrate de que tus cambios no rompan las pruebas existentes
- Añade pruebas para nuevas funcionalidades
- Ejecuta las pruebas antes de enviar un Pull Request:
  ```bash
  php artisan test
  ```

## Reportar Problemas

Si encuentras un error o tienes una sugerencia:

1. Verifica que el problema no haya sido reportado anteriormente
2. Crea un nuevo issue con:
   - Descripción clara del problema
   - Pasos para reproducirlo
   - Comportamiento esperado vs. actual
   - Capturas de pantalla si es posible
   - Información del entorno (navegador, sistema operativo, etc.)

## Solicitudes de Funcionalidades

Para solicitar nuevas funcionalidades:

1. Describe claramente la funcionalidad deseada
2. Explica por qué sería útil para el proyecto
3. Proporciona ejemplos de cómo debería funcionar

¡Gracias por contribuir a PetBook!