# Modelos y Relaciones

Este documento describe los modelos principales de la aplicación PetBook y sus relaciones.

## Diagrama de Relaciones

```
User
 ├── Pets (1:N)
 ├── LostPets (1:N)
 ├── AdoptionsAsCreator (1:N)
 ├── AdoptionsAsAdopter (1:N)
 ├── Posts (1:N)
 ├── Comments (1:N)
 └── Donations (1:N)

Pet
 ├── User (N:1)
 └── Adoption (1:1)

Adoption
 ├── Creator (N:1 → User)
 ├── Adopter (N:1 → User)
 └── Pet (N:1)

LostPet
 └── User (N:1)

Post
 ├── User (N:1)
 └── Comments (1:N)

Comment
 ├── User (N:1)
 └── Post (N:1)

Donation
 └── User (N:1)
```

## Descripción de Modelos

### User

Representa a los usuarios registrados en la plataforma.

**Atributos principales:**
- `user_id` (PK): Identificador único del usuario
- `user_name`: Nombre del usuario
- `user_phone`: Teléfono de contacto
- `city`: Ciudad de residencia
- `email`: Correo electrónico
- `password`: Contraseña (encriptada)
- `description`: Descripción personal

**Relaciones:**
- `pets()`: Mascotas publicadas por el usuario (1:N)
- `lostPets()`: Mascotas perdidas reportadas por el usuario (1:N)
- `adoptionsAsCreator()`: Adopciones donde el usuario es el creador (1:N)
- `adoptionsAsAdopter()`: Adopciones donde el usuario es el adoptante (1:N)
- `posts()`: Publicaciones de blog creadas por el usuario (1:N)
- `comments()`: Comentarios realizados por el usuario (1:N)

### Pet

Representa las mascotas disponibles para adopción.

**Atributos principales:**
- `pet_id` (PK): Identificador único de la mascota
- `pet_name`: Nombre de la mascota
- `location`: Ubicación de la mascota
- `description`: Descripción de la mascota
- `pet_species`: Especie (perro, gato, etc.)
- `pet_status`: Estado de la mascota
- `health_condition`: Condición de salud
- `castrated`: Si está castrada/esterilizada
- `pet_photo`: Foto de la mascota
- `user_id` (FK): Usuario que publicó la mascota

**Relaciones:**
- `user()`: Usuario que publicó la mascota (N:1)
- `adoption()`: Proceso de adopción asociado (1:1)

### Adoption

Representa el proceso de adopción de una mascota.

**Atributos principales:**
- `adoption_id` (PK): Identificador único de la adopción
- `creator_user_id` (FK): Usuario que creó la adopción
- `adopter_user_id` (FK): Usuario que adopta la mascota
- `pet_id` (FK): Mascota que se adopta
- `adoption_date`: Fecha de adopción

**Relaciones:**
- `creator()`: Usuario que creó la adopción (N:1)
- `adopter()`: Usuario que adopta la mascota (N:1)
- `pet()`: Mascota que se adopta (N:1)

### LostPet

Representa las mascotas perdidas reportadas.

**Atributos principales:**
- `id` (PK): Identificador único
- `user_id` (FK): Usuario que reporta la mascota perdida
- `pet_name`: Nombre de la mascota
- `last_seen`: Último lugar donde se vio
- `lost_date`: Fecha en que se perdió
- `pet_species`: Especie de la mascota
- `pet_photo`: Foto de la mascota
- `description`: Descripción adicional

**Relaciones:**
- `user()`: Usuario que reportó la mascota perdida (N:1)

### Post

Representa las publicaciones del blog.

**Atributos principales:**
- `id` (PK): Identificador único
- `user_id` (FK): Usuario que creó la publicación
- `title`: Título de la publicación
- `content`: Contenido de la publicación
- `category`: Categoría de la publicación

**Relaciones:**
- `user()`: Usuario que creó la publicación (N:1)
- `comments()`: Comentarios de la publicación (1:N)

### Comment

Representa los comentarios en las publicaciones del blog.

**Atributos principales:**
- `id` (PK): Identificador único
- `post_id` (FK): Publicación a la que pertenece
- `user_id` (FK): Usuario que creó el comentario
- `content`: Contenido del comentario

**Relaciones:**
- `user()`: Usuario que creó el comentario (N:1)
- `post()`: Publicación a la que pertenece (N:1)

### Donation

Representa las donaciones realizadas por los usuarios.

**Atributos principales:**
- `id` (PK): Identificador único
- `user_id` (FK): Usuario que realizó la donación
- `amount`: Monto de la donación
- `currency`: Moneda de la donación
- `payment_id`: ID de pago externo
- `payment_method`: Método de pago
- `status`: Estado de la donación
- `donor_name`: Nombre del donante
- `donor_email`: Email del donante
- `message`: Mensaje del donante

**Relaciones:**
- `user()`: Usuario que realizó la donación (N:1)