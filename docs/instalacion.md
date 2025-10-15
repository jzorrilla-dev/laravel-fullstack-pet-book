# Guía de Instalación Detallada

Esta guía proporciona instrucciones paso a paso para configurar el entorno de desarrollo de PetBook.

## Requisitos Previos

Antes de comenzar, asegúrate de tener instalado:

- PHP 8.1 o superior
- Composer
- Node.js y NPM
- MySQL o PostgreSQL
- Git

## Pasos de Instalación

### 1. Clonar el Repositorio

```bash
git clone https://github.com/tu-usuario/laravel-fullstack-pet-book.git
cd laravel-fullstack-pet-book
```

### 2. Instalar Dependencias de PHP

```bash
composer install
```

### 3. Configurar el Entorno

Copia el archivo de ejemplo de entorno y configúralo:

```bash
cp .env.example .env
```

Edita el archivo `.env` con la configuración de tu base de datos:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=petbook
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 4. Generar Clave de Aplicación

```bash
php artisan key:generate
```

### 5. Crear la Base de Datos

Crea una base de datos vacía con el nombre especificado en tu archivo `.env`.

### 6. Ejecutar Migraciones

```bash
php artisan migrate
```

Si deseas cargar datos de prueba:

```bash
php artisan db:seed
```

### 7. Instalar Dependencias de Frontend

```bash
npm install
```

### 8. Compilar Assets

Para desarrollo:
```bash
npm run dev
```

Para producción:
```bash
npm run build
```

### 9. Iniciar el Servidor de Desarrollo

```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`.

## Configuración Adicional

### Almacenamiento de Imágenes

Para configurar el almacenamiento de imágenes de mascotas:

1. Crear enlace simbólico para el almacenamiento:
   ```bash
   php artisan storage:link
   ```

2. Asegúrate de que los directorios de almacenamiento tengan permisos adecuados:
   ```bash
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```

### Configuración de Correo Electrónico

Para habilitar el envío de correos electrónicos, configura las siguientes variables en tu archivo `.env`:

```
MAIL_MAILER=smtp
MAIL_HOST=tu_servidor_smtp
MAIL_PORT=587
MAIL_USERNAME=tu_usuario
MAIL_PASSWORD=tu_contraseña
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=correo@ejemplo.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Solución de Problemas Comunes

### Error de Permisos

Si encuentras errores de permisos, asegúrate de que el servidor web tenga permisos de escritura en los directorios `storage` y `bootstrap/cache`.

### Error de Conexión a la Base de Datos

Verifica que las credenciales en tu archivo `.env` sean correctas y que el servicio de base de datos esté en ejecución.

### Error al Compilar Assets

Si encuentras errores al compilar los assets, intenta:

```bash
npm cache clean --force
rm -rf node_modules
npm install
npm run dev
```