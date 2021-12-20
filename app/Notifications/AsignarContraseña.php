<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AsignarContraseña extends Notification
{
    use Queueable;

    protected $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        //
        $this->token=$token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Asignacion de contraseña')
                    ->greeting('Saludos '.$notifiable->name.' '.$notifiable->lastname)
                    ->line('Mediante este correo electronico usted podra asignar una contraseña para acceder a la aplicacion informatica para Gestion de Documentos Internos del GAD de Tulcan ')
                    ->action('Asignar Contraseña', url('/password/reset/'.$this->token))
                    ->line('Si usted no ha solicitado acceso a la aplicacion no haga nada')
                    ->salutation('Atentamente: GAD de Tulcan');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
