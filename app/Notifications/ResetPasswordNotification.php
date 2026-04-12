<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    public function toMail(mixed $notifiable): MailMessage
    {
        $url = $this->resetUrl($notifiable);

        return (new MailMessage)
            ->subject('Réinitialisation de votre mot de passe — KapitalStark')
            ->view('mail.password-reset', [
                'url'  => $url,
                'name' => $notifiable->name,
            ]);
    }
}
