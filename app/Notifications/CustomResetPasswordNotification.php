<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPasswordNotification extends Notification
{
    use Queueable;


     public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
         $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
         return (new MailMessage)
            ->subject('Notifikasi Reset Password Anda') // Ubah subjek email di sini
            ->line('Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.') // Ubah teks baris pertama
            ->action('Reset Password', url(config('app.url').route('password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()], false))) // Ubah teks tombol di sini
            ->line('Link reset password ini akan kedaluwarsa dalam 60 menit.') // Ubah teks baris kedua
            ->line('Jika Anda tidak merasa meminta reset password, abaikan email ini.');
    }
    

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
