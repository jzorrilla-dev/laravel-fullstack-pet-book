# Instrucciones para Desplegar en Render.com

## Configuración de PostgreSQL

1. En el dashboard de Render, ve a "New" y selecciona "PostgreSQL".
2. Configura tu base de datos:
   - Nombre: `petbook-db` (o el nombre que prefieras)
   - Usuario: Deja que Render genere uno automáticamente
   - Versión: 15 (recomendada)
   - Región: Selecciona la más cercana a tus usuarios
   - Plan: Selecciona según tus necesidades (Free tiene 90 días gratis)

3. Anota las credenciales que Render te proporciona:
   - Database URL
   - Internal Database URL
   - Host
   - Port
   - Database
   - Username
   - Password

## Configuración de Almacenamiento S3

Para almacenar archivos subidos por los usuarios (imágenes de mascotas, etc.):

1. Crea una cuenta en AWS o usa un servicio compatible con S3 como DigitalOcean Spaces o Cloudflare R2.
2. Crea un bucket y configura las credenciales de acceso.
3. Obtén:
   - Access Key ID
   - Secret Access Key
   - Bucket Name
   - Region
   - Endpoint URL (si usas un servicio alternativo a AWS)

## Despliegue de la Aplicación Web

1. En el dashboard de Render, ve a "New" y selecciona "Web Service".
2. Conecta tu repositorio de GitHub.
3. Configura el servicio:
   - Nombre: `petbook` (o el nombre que prefieras)
   - Runtime: Docker
   - Branch: `main` (o la rama que uses para producción)
   - Build Command: `chmod +x build.sh && ./build.sh`
   - Start Command: `php artisan serve --host 0.0.0.0 --port $PORT`
   - Plan: Selecciona según tus necesidades

4. Configura las variables de entorno (en la sección "Environment"):
   - Todas las variables definidas en `.env.example`
   - Asegúrate de incluir las credenciales de PostgreSQL y S3
   - Añade `PORT=8000`

5. Haz clic en "Create Web Service" y espera a que se complete el despliegue.

## Verificación Post-Despliegue

1. Verifica que la aplicación esté funcionando correctamente.
2. Comprueba que las imágenes se suban correctamente a S3.
3. Verifica que la base de datos esté conectada y funcionando.
4. Revisa los logs en caso de errores.

## Mantenimiento

- Cada vez que hagas push a la rama configurada, Render reconstruirá y desplegará automáticamente tu aplicación.
- Puedes configurar despliegues manuales si prefieres más control.
- Monitorea el uso de recursos para evitar cargos inesperados.