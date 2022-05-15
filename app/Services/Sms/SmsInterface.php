<?php

namespace App\Services\Sms;

use App\Models\User;

interface SmsInterface
{
    public function sendMsg($phone_number, $message, $templateId);

    public function sendMsgToUser(User $user, $message,$templateId);
}
