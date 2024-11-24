<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class SmsApiChannel
{
    public function __construct()
    {
    }

    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);
        $message->send();

    }

}
