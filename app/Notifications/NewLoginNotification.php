<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLoginNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ip;

    public function __construct($ip)
    {
        $this->ip = $ip;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Login dari IP Baru')
            ->line('Kami mendeteksi login dari alamat IP baru:')
            ->line('IP: ' . $this->ip)
            ->line('Jika ini bukan Anda, segera periksa akun Anda.');
    }
}
