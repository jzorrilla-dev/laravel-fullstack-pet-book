<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\LostPetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

// Rutas públicas (sin autenticación)
Route::get('/', [PetController::class, 'home'])->name('home');
Route::get('/pets', [PetController::class, 'index'])->name('pets.index');
Route::get('/pets/{pet_id}', [PetController::class, 'show'])
    ->name('pets.show')
    ->where('pet_id', '[0-9]+'); // Ruta dinámica pública, solo números
Route::get('/lostpets', [LostPetController::class, 'index'])->name('lostpets.index');
Route::get('/lostpets/{id}', [LostPetController::class, 'show'])
    ->name('lostpets.show')
    ->where('id', '[0-9]+'); // Ruta dinámica pública, solo números

// Páginas informativas
Route::view('/about', 'about')->name('about');
Route::view('/contactos', 'contactos')->name('contactos');

// Rutas de donaciones
Route::get('/donations', [App\Http\Controllers\DonationController::class, 'index'])->name('donations.index');
Route::get('/donations/create', [App\Http\Controllers\DonationController::class, 'create'])->name('donations.create');
Route::post('/donations/checkout', [App\Http\Controllers\DonationController::class, 'checkout'])->name('donations.checkout');
Route::get('/donations/success', [App\Http\Controllers\DonationController::class, 'success'])->name('donations.success');
Route::get('/donations/cancel', [App\Http\Controllers\DonationController::class, 'cancel'])->name('donations.cancel');

// Rutas de Blogs (CORREGIDAS)
Route::middleware('auth')->group(function () {
    // 1. CREATE (GET, ruta específica) - Debe ir antes que {post}
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

    // 2. INDEX (GET, ruta base)
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

    // 3. STORE (POST)
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // 4. SHOW (GET, ruta genérica con parámetro) - DEBE IR AL FINAL
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

    // 5. EDIT, UPDATE, DELETE (las demás rutas dinámicas)
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // rutas para los comentarios
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::get('/comments/{post_id}/{comment_id}', [CommentController::class, 'show'])->name('comments.show');

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

    // 5. EDIT, UPDATE, DELETE (las demás rutas dinámicas)
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Perfil del usuario autenticado
    Route::get('/user/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::get('/user/profile/edit', [AuthController::class, 'editProfile'])->name('profile.edit');
    Route::put('/user/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Rutas para mascotas
    Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
    Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
    Route::get('/pets/{pet_id}/edit', [PetController::class, 'edit'])->name('pets.edit');
    Route::put('/pets/{pet_id}', [PetController::class, 'update'])->name('pets.update');
    Route::delete('/pets/{pet_id}', [PetController::class, 'destroy'])->name('pets.destroy');

    // Rutas para mascotas perdidas
    Route::get('/lostpets/create', [LostPetController::class, 'create'])->name('lostpets.create');
    Route::post('/lostpets', [LostPetController::class, 'store'])->name('lostpets.store');
    Route::get('/lostpets/{id}/edit', [LostPetController::class, 'edit'])->name('lostpets.edit');
    Route::put('/lostpets/{id}', [LostPetController::class, 'update'])->name('lostpets.update');
    Route::delete('/lostpets/{id}', [LostPetController::class, 'destroy'])->name('lostpets.destroy');
});
