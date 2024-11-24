<?php

namespace App\Notifications;

use App\Library\RUSms;

class SmsMessage
{
    public $content;
    public $to;

    public function __construct($content = '')
    {
        $this->content = $content;
    }

    public function content($content)
    {
        $this->content = $content;
        return $this;

    }

    public function to($to)
    {
        $this->to = $to;
        return $this;
    }

    public function send()
    {
        // todo: remove in production
        if (config('app.debug')){
            RUSms::sendSms('01911064969', $this->content, 'RU');
        } else{
            RUSms::sendSms($this->to, $this->content, 'RU');
        }

    }

}
