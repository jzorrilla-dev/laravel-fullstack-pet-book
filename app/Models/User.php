<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Importa tu notificador

class User extends Authenticatable
{
    // <-- ¡Añade Notifiable y CanResetPassword aquí!
    use CanResetPassword, HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'user_id'; // Clave primaria personalizada

    protected $fillable = [
        'user_name',
        'user_phone',
        'city',
        'email',
        'password',
        'description',
        'photo',
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
    ];

    // Relaciones
    public function pets()
    {
        return $this->hasMany(Pet::class, 'user_id');
    }

    public function lostPets()
    {
        return $this->hasMany(LostPet::class, 'user_id');
    }

    public function adoptionsAsCreator()
    {
        return $this->hasMany(Adoption::class, 'creator_user_id');
    }

    public function adoptionsAsAdopter()
    {
        return $this->hasMany(Adoption::class, 'adopter_user_id');
    }

    // Relación con los posts creados por el usuario
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'user_id');
    }

    // Relación con los comentarios creados por el usuario
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'user_id');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
