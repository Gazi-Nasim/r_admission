<?php

namespace App\Notifications;

use App\Channels\SmsApiChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class SmsPinNotification extends Notification
{
    use Queueable;

    private $verification_code;
    private $name;
    private $mobile_no;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $mobile_no, $verification_code)
    {
        $this->name              = $name;
        $this->mobile_no         = $mobile_no;
        $this->verification_code = $verification_code;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SmsApiChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return SmsMessage
     */
    public function toSms($notifiable)
    {
        $content = sprintf("%s, Your PIN for RU Admission is %s",
            $this->name,
            $this->verification_code);

        return (new SmsMessage)
            ->content($content)
            ->to($this->mobile_no);
    }


}
