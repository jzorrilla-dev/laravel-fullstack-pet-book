# PetBook - Plataforma de Adopción de Mascotas

PetBook es una aplicación web desarrollada con Laravel y Tailwind CSS que facilita la adopción de mascotas, permite reportar mascotas perdidas y fomenta la comunidad de amantes de los animales a través de un blog integrado.

## Características Principales

- **Adopción de Mascotas**: Publicación y búsqueda de mascotas disponibles para adopción
- **Mascotas Perdidas**: Sistema para reportar y encontrar mascotas extraviadas
- **Blog Comunitario**: Espacio para compartir historias, consejos y experiencias
- **Perfiles de Usuario**: Gestión de información personal y de mascotas
- **Diseño Responsivo**: Experiencia optimizada para dispositivos móviles y de escritorio

## Requisitos Técnicos

- PHP 8.1 o superior
- Composer
- Node.js y NPM
- MySQL o PostgreSQL
- Extensiones PHP: BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

## Instalación

1. Clonar el repositorio:
   ```
   git clone https://github.com/tu-usuario/laravel-fullstack-pet-book.git
   cd laravel-fullstack-pet-book
   ```

2. Instalar dependencias de PHP:
   ```
   composer install
   ```

3. Instalar dependencias de JavaScript:
   ```
   npm install
   ```

4. Copiar el archivo de entorno:
   ```
   cp .env.example .env
   ```

5. Generar clave de aplicación:
   ```
   php artisan key:generate
   ```

6. Configurar la base de datos en el archivo `.env`

7. Ejecutar migraciones:
   ```
   php artisan migrate
   ```

8. Compilar assets:
   ```
   npm run dev
   ```

9. Iniciar el servidor:
   ```
   php artisan serve
   ```

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
3. Realiza tus cambios y haz commit (`git commit -m 'Añadir nueva funcionalidad'`)
4. Sube tus cambios (`git push origin feature/nueva-funcionalidad`)
5. Abre un Pull Request

## Licencia

Este proyecto está licenciado bajo [MIT License](LICENSE).

## Contacto

Para más información, contacta a [tu-email@ejemplo.com](mailto:tu-email@ejemplo.com)
