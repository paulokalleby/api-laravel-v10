<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    private $token;

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
        
        $url = config('app.frontend_url')."/auth/reset-password/{$this->token}";

        return (new MailMessage)
                    ->subject('Nova Senha')
                    ->line('Você está recebendo este e-mail porque recebemos um pedido de recuperação de senha.')
                    ->action('Atualizar Senha', $url)
                    ->line('Se você não solicitou uma alteração da senha, nenhuma ação deve ser feita!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
