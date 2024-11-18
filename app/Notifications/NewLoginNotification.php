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
    protected $userAgent;

    public function __construct($ip, $userAgent)
    {
        $this->ip = $ip;
        $this->userAgent = $userAgent;
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
            ->line('Browser/Device: ' . $this->userAgent)
            ->line('Jika ini bukan Anda, segera periksa akun Anda.');
    }
}
