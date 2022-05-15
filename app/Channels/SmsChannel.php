<?php

namespace App\Channels;

use App\Services\Sms\SmsInterface;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    private $smsService;

    function __construct(SmsInterface $smsService)
    {
        $this->smsService = $smsService;
    }

    public function send($notifiable, Notification $notification)
    {

        $message = $notification->toSms($notifiable);
        $message->send($this->smsService);

       // Or use dryRun() for testing to send it, without sending it for real.
       // $message->dryRun()->send();

    }


}
