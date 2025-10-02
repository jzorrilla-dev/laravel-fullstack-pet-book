<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\LostPetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

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
