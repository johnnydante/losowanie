<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('losowanie.tendaj@gmail.com')
            ->greeting('Witaj,')
            ->subject('Reset hasła w rodzinnym losowaniu')
            ->line('Otrzymałeś ten e-mail, ponieważ prosiłeś o wysłanie linku  do zresetowaia hasła w rodzinnym losowaniu, kliknij w poniższy przycisk, aby ustawić nowe hasło')
            ->action('Zresetuj hasło', url('password/reset', $this->token))
            ->line('Jeśli to nie Ty prosiłeś o reset hasła, to znaczy, że ktoś zrobił to za Ciebie podając Twój e-mail, niezwłocznie zgłoś ten fakt administratorowi rodzinnego losowania');
    }
}