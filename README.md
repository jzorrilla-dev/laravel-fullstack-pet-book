# PetBook - Plataforma de Adopción de Mascotas

PetBook es una aplicación web desarrollada con Laravel y Tailwind CSS que facilita la adopción de mascotas, permite reportar mascotas perdidas y fomenta la comunidad de amantes de los animales a través de un blog integrado.

## Características Principales

- **Adopción de Mascotas**: Publicación y búsqueda de mascotas disponibles para adopción
- **Mascotas Perdidas**: Sistema para reportar y encontrar mascotas extraviadas
- **Blog Comunitario**: Espacio para compartir historias, consejos y experiencias
- **Perfiles de Usuario**: Gestión de información personal y de mascotas
- **Diseño Responsivo**: Experiencia optimizada para dispositivos móviles y de escritorio

## Requisitos Técnicos

- PHP 8.2 o superior
- Composer
- Node.js y pnpm (NO usar npm)
- PostgreSQL (vía Supabase)
- Docker y Docker Compose
- Extensiones PHP: BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML, GD

## Instalación

1. Clonar el repositorio:
   ```
   git clone https://github.com/tu-usuario/laravel-fullstack-pet-book.git
   cd laravel-fullstack-pet-book
   ```

 2. Levantar contenedores Docker:
    ```
    ./vendor/bin/sail up -d
    ```

3. Instalar dependencias de JavaScript (usar pnpm, NO npm - ejecutar FUERA de sail):
    ```
    pnpm install
    ```

4. Copiar el archivo de entorno:
   ```
   cp .env.example .env
   ```

5. Generar clave de aplicación:
   ```
   ./vendor/bin/sail php artisan key:generate
   ```

6. Configurar la base de datos en el archivo `.env` (Supabase)

7. Ejecutar migraciones:
   ```
   ./vendor/bin/sail php artisan migrate
   ```

8. Compilar assets:
   ```
   pnpm build
   ```

## Comandos Útiles

### Desarrollo
```bash
# Levantar contenedores
./vendor/bin/sail up -d

# Ver contenedores activos
docker ps

# Ver logs
docker logs laravel-fullstack-pet-book-laravel.test-1

# Detener contenedores
./vendor/bin/sail down
```

### Testing y Linting
```bash
# Ejecutar tests
./vendor/bin/sail php artisan test

# Ejecutar tests con cobertura
./vendor/bin/sail php artisan test --coverage

# Linting con Pint
./vendor/bin/sail php vendor/bin/pint

# Análisis estático con PHPStan
./vendor/bin/sail php vendor/bin/phpstan analyse
```

### Bases de Datos
```bash
# Ejecutar migraciones
./vendor/bin/sail php artisan migrate

# Rollback de migraciones
./vendor/bin/sail php artisan migrate:rollback

# Seed de base de datos
./vendor/bin/sail php artisan db:seed

# Ver estado de migraciones
./vendor/bin/sail php artisan migrate:status
```

## Stack Tecnológico

- **Backend**: Laravel 10+ con PHP 8.2+
- **Base de datos**: PostgreSQL (Supabase)
- **Frontend**: Blade templates + Tailwind CSS + Alpine.js
- **Imágenes**: Cloudinary
- **Testing**: Pest
- **Linting**: Laravel Pint (PSR-12)
- **Static Analysis**: PHPStan/Larastan (nivel 3)

## Estructura del Proyecto

### Modelos Principales
- `User`: Gestión de usuarios y autenticación
- `Pet`: Información de mascotas disponibles para adopción
- `LostPet`: Registro de mascotas perdidas
- `Adoption`: Proceso de adopción
- `Post`: Publicaciones del blog
- `Comment`: Comentarios en publicaciones

### Controladores Clave
- `PetController`: Gestión de mascotas para adopción
- `LostPetController`: Gestión de mascotas perdidas
- `AdoptionController`: Proceso de solicitud de adopción
- `PostController`: Gestión del blog
- `CommentController`: Gestión de comentarios

## Contribución

Si deseas contribuir al proyecto, por favor:

1. Crea un fork del repositorio
2. Crea una rama para tu funcionalidad (`git checkout -b feature/nueva-funcionalidad`)
3. Realiza tus cambios y haz commit (`git commit -m 'feat: añadir nueva funcionalidad'`)
4. Ejecuta lint y tests antes de hacer commit:
   ```
   ./vendor/bin/sail php vendor/bin/pint
   ./vendor/bin/sail php vendor/bin/phpstan analyse
   ./vendor/bin/sail php artisan test
   ```
5. Sube tus cambios (`git push origin feature/nueva-funcionalidad`)
6. Abre un Pull Request

## Despliegue

Este proyecto está configurado para desplegarse en **Render** con **Supabase** como base de datos. Ver `RENDER_DEPLOY.md` para instrucciones detalladas.

## Licencia

Este proyecto está licenciado bajo [MIT License](LICENSE).

## Contacto

Para más información, contacta a [emiliozorrillacabral@hotmail.com](mailto:emiliozorrillacabral@hotmail.com)
