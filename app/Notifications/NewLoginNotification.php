<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLoginNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ip;
    protected $userAgent;
    protected $user;

    public function __construct(User $user, $ip, $userAgent)
    {
        $this->ip = $ip;
        $this->userAgent = $userAgent;
        $this->user = $user;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New login in your account!')
            ->line('Dear ' . $this->user->name . ',')
            ->line('Someone has just successfully logged into your account. More information about the login:')
            ->line('Date Time: ' . date('d F Y H:i:s'))
            ->line('IP: ' . $this->ip)
            ->line('Browser/Device: ' . $this->userAgent)
            ->line('Please change your password and contact us immediately if you have not done this registration. Otherwise, you can simply ignore this message.');
    }
}
