<?php

namespace App\Notifications;

use App\Models\Hsc;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailAdmitCardNotification extends Notification implements ShouldQueue
{
    use Queueable;


    public function __construct()
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {


        $mail = new MailMessage;

//        $url = url('/invoice/'.$this->invoice->id);
        //$url = route('site.getAdmitCard', $encryptedData);

        return $mail
            ->subject('RU Admit Card')
            ->markdown('notifications.emails.admit_card', [
                'student' => $notifiable,
            ]);


    }

    public function toArray($notifiable): array
    {
        return [];
    }


}
