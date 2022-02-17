<?php

namespace App\Mail\Acr;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AcrAlertMail extends Mailable
{
    /**
     * @var mixed
     */
    public $userPendingAcrs;
    /**
     * @var mixed
     */
    public $targetUser;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($targetUser, $userPendingAcrs)
    {
        $this->userPendingAcrs = $userPendingAcrs;
        $this->targetUser = $targetUser;
        //Log::info("targetUser = ".print_r($targetUser, true));
        //Log::info("userPendingAcrs = ".print_r($userPendingAcrs, true));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Alert for pending ACR at '.$this->targetUser->name.'( '.$this->targetUser->employee_id.' )'.now()->format('d-m-y H:i:s'))
            ->markdown('emails/acr/alertmail');
    }
}
