# AGENTS.md - Agentic Coding Guidelines

This file provides guidelines for agentic coding agents working in this Laravel fullstack project (PetBook - a pet social network).

## Project Overview

- **Framework**: Laravel 10+ with PHP 8.2+
- **Frontend**: Blade templates with Alpine.js and Tailwind CSS
- **Database**: PostgreSQL (via Supabase)
- **Testing**: PHPUnit with Pest support available
- **Linting**: Laravel Pint (PSR-12)

## Build / Lint / Test Commands

### IMPORTANTE: Cómo ejecutar comandos correctamente

**Forma correcta de usar Sail:**
```bash
# Verificar que los contenedores estén corriendo primero
docker ps

# Luego ejecutar comandos con la sintaxis correcta
./vendor/bin/sail up -d                          # Levantar contenedores
./vendor/bin/sail php artisan test               # Ejecutar tests
./vendor/bin/sail php vendor/bin/pint            # Ejecutar Pint
./vendor/bin/sail php vendor/bin/phpstan analyse # Ejecutar PHPStan
```

**Errores comunes a evitar:**
```bash
# ❌ INCORRECTO - agregar ./vendor/bin/ en medio
./vendor/bin/sail ./vendor/bin/pint

# ✅ CORRECTO - usar 'php' directamente después de 'sail'
./vendor/bin/sail php vendor/bin/pint
./vendor/bin/sail php artisan route:list
```

### PHP/Laravel Commands (usar Sail)

```bash
# Run all tests
./vendor/bin/sail php artisan test

# Run a single test (filter by name)
./vendor/bin/sail php artisan test --filter=test_name_here

# Run tests with coverage
./vendor/bin/sail php artisan test --coverage

# Run specific test suite
./vendor/bin/sail php vendor/bin/phpunit --testsuite=Unit
./vendor/bin/sail php vendor/bin/phpunit --testsuite=Feature

# Run a specific test file
./vendor/bin/sail php vendor/bin/phpunit tests/Feature/ExampleTest.php

# Run a specific test method
./vendor/bin/sail php vendor/bin/phpunit tests/Feature/ExampleTest.php --filter=test_the_application_returns_a_successful_response

# Lint PHP code (Pint - PSR-12)
./vendor/bin/sail php vendor/bin/pint

# Lint with dry-run (check without fixing)
./vendor/bin/sail php vendor/bin/pint --test

# Static analysis with PHPStan/Larastan (nivel 3)
./vendor/bin/sail php vendor/bin/phpstan analyse

# Check route list
./vendor/bin/sail php artisan route:list

# Check migrations status
./vendor/bin/sail php artisan migrate:status

# Generate app key
./vendor/bin/sail php artisan key:generate
```

### Frontend Commands

**IMPORTANTE: Siempre usar pnpm, nunca usar npm**

```bash
# Install dependencies
pnpm install

# Run development server
pnpm dev

# Build for production
pnpm build
```

### Docker Commands

```bash
# Build and start containers (SIEMPRE usar ./vendor/bin/sail)
./vendor/bin/sail up -d

# Verificar estado de contenedores
docker ps

# Ver logs de un contenedor específico
docker logs laravel-fullstack-pet-book-laravel.test-1

# Ejecutar comandos directamente en el contenedor (alternativa a sail)
docker exec laravel-fullstack-pet-book-laravel.test-1 php artisan test
docker exec laravel-fullstack-pet-book-laravel.test-1 php vendor/bin/pint
docker exec laravel-fullstack-pet-book-laravel.test-1 php vendor/bin/phpstan analyse
```

### Static Analysis (PHPStan/Larastan)

Este proyecto incluye configuración de Laravel para análisis estático:

```bash
# Ejecutar análisis estático
./vendor/bin/sail php vendor/bin/phpstan analyse

# Nivel configurado: 3 (balance entre rigurosidad y viabilidad)
# Archivos analizados: app/
# Excluidos: Middleware de Laravel, SocialAuthController
```

**Errores comunes de PHPStan y cómo resolverlos:**
- Métodos sin return type → Agregar tipo de retorno al método
- Relaciones sin tipos genéricos → Usar `BelongsTo<User>`, `HasMany<Post>`
- Arrays sin tipos → Usar `array<string, mixed>` o similar

## Code Style Guidelines

### General Conventions

- **PHP Version**: 8.2+ - Use modern PHP features (typed properties, readonly, enums)
- **Indent Style**: 4 spaces (see `.editorconfig`)
- **Line Endings**: LF (Unix)
- **Charset**: UTF-8
- **Final Newline**: Yes
- **Trailing Whitespace**: Trim

### Naming Conventions

| Element | Convention | Example |
|---------|------------|---------|
| Classes | PascalCase | `PostController`, `UserModel` |
| Methods | camelCase | `getUser()`, `createPost()` |
| Variables | camelCase | `$userName`, `$postData` |
| Constants | SCREAMING_SNAKE_CASE | `MAX_RETRY_COUNT` |
| Database Tables | snake_case | `lost_pets`, `adoptions` |
| Foreign Keys | `table_id` format | `user_id`, `pet_id` |
| Routes | kebab-case | `/lost-pets/create` |

### File Organization

- One class per file
- Class name matches file name
- PSR-4 autoloading: `App\Models\User` in `app/Models/User.php`
- Use import statements at top of files

### PHP Best Practices

```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Type hint all parameters and return types
    public function show(Request $request, int $id): \Illuminate\Http\Response
    {
        // Use dependency injection
        $user = User::findOrFail($id);

        return response()->json(['user' => $user]);
    }

    // Validate all user input
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
        ]);

        User::create($validated);

        return redirect()->route('users.index');
    }
}
```

### Models (Eloquent)

- Use `$fillable` or `$guarded` for mass assignment
- Define relationships with return types
- Use scopes for reusable query logic
- Eager load relationships to avoid N+1 queries

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pet extends Model
{
    protected $fillable = ['name', 'species', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lostPets(): HasMany
    {
        return $this->hasMany(LostPet::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
```

### Error Handling

- Use `try/catch` for external API calls
- Return appropriate HTTP status codes
- Use Laravel's validation for form requests
- Log errors with context using `logger()` or `Log::error()`

```php
try {
    $response = $this->externalService->fetch($id);
} catch (ServiceException $e) {
    logger()->error('Service failed', ['id' => $id, 'error' => $e->getMessage()]);
    return response()->json(['error' => 'Service unavailable'], 503);
}
```

### Database Migrations

- Use foreign keys with `constrained()` and `cascadeOnDelete()`
- Use appropriate data types (bigInteger for IDs, text for long content)
- Always include `up()` and `down()` methods with return types

```php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('species');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
```

### Frontend (Blade/Tailwind/Alpine)

- Use semantic HTML
- Follow Tailwind CSS class conventions
- Use Alpine.js for simple interactivity
- Keep Blade templates clean; push complex logic to controllers/services

```html
<div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-4">{{ $pet->name }}</h1>
    <p class="text-gray-600">{{ $pet->species }}</p>
</div>
```

### Testing Conventions

- Test file location: `tests/Feature/` or `tests/Unit/`
- Test class name: `ClassNameTest`
- Test method: `test_method_description`
- Use descriptive assertion messages

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserAuthenticationTest extends TestCase
{
    public function test_user_can_register_with_valid_data(): void
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/home');
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }
}
```

### Git Commit Messages

- Mensajes completamente en español
- Usar prefijos opcionales en inglés (feat, fix, style, chore, refactor, etc.)
- Mantener línea de asunto bajo 50 caracteres
- Ejemplo: `git commit -m "fix: ocultar icono de engranaje en navbar para dispositivos móviles pequeños para evitar solapamientos"`
- Referenciar issues con `#123` si aplica

## Existing Agent Skills

This project has specialized agents in `.agents/skills/`:

- **laravel-specialist** - Laravel 10+, Eloquent, Sanctum, Livewire, queues
- **supabase-postgres-best-practices** - PostgreSQL query optimization, RLS, indexes

## Key Files

| Path | Purpose |
|------|---------|
| `composer.json` | PHP dependencies |
| `package.json` | Node dependencies |
| `phpunit.xml` | Test configuration |
| `.editorconfig` | Editor formatting rules |
| `vite.config.js` | Build configuration |
| `tailwind.config.js` | CSS configuration |
| `docker-compose.yml` | Development environment |

## Environment

- Copy `.env.example` to `.env` and configure
- Run `php artisan key:generate` after setup
- Database configuration via Supabase credentials in `.env`
