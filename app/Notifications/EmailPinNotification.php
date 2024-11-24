<?php

namespace App\Notifications;

use App\Models\Hsc;
use Faker\Factory as FakerFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailPinNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private Hsc $student;
    private $name;
    private $email;
    private $verification_code;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $email, $verification_code)
    {
        $this->name              = $name;
        $this->email             = $email;
        $this->verification_code = $verification_code;

        if ( config('app.debug') ) {
            $this->delay = now()->addSeconds(5);
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $faker = FakerFactory::create();

        return (new MailMessage)
            ->greeting('Hello '.$this->name.'!')
            ->line("Your PIN for the email verification is: ".$this->verification_code)
            ->line('input the PIN in the verification form to verify your email.')
            ->salutation("Regards, \nRU Admission System");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
