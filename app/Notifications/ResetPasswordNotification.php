<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public string $token;

    public static ?\Closure $toMailCallback = null;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return array<string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        // URL segura: solo el token, sin email en la URL
        $url = route('password.reset', [
            'token' => $this->token,
        ]);

        return (new MailMessage)
            ->subject('Restablecimiento de contraseña')
            ->line('Has recibido este correo porque hemos recibido una solicitud de restablecimiento de contraseña para tu cuenta.')
            ->action('Restablecer Contraseña', $url)
            ->line('Este enlace de restablecimiento de contraseña expirará en 60 minutos.')
            ->line('Si no solicitaste un restablecimiento de contraseña, no se requiere ninguna acción adicional.');
    }

    public static function toMailUsing(\Closure $callback): void
    {
        static::$toMailCallback = $callback;
    }
}
