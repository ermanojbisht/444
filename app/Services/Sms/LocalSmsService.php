<?php

namespace App\Services\Sms;

use App\Models\User;

class LocalSmsService implements SmsInterface
{

    public function sendMsgToUser(User $user, $message, $templateId)
    {
        if ($user->contact_no) {
            $this->sendMsg($user->contact_no, $message, $templateId);
        }
    }

    public function sendMsg($phone_number, $message, $templateId)
    {
        \Log::info(['user phone_number'=>$phone_number,'message'=>$message,'templateId'=>$templateId]);
    }
}
