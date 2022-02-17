<?php

namespace App\Mail\Acr;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AcrAlertMail extends Mailable
{
    public $userPendingAcrs;
    public $targetUser;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userPendingAcrs , $targetUser)
    {
        $this->userPendingAcrs = $userPendingAcrs;
        $this->targetUser = $targetUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Alert for pending ACR at '.$this->targetUser->name. '( '.$this->targetUser->employee_id.' )'.now()->format('d-m-y H:i:s'))
        ->markdown('emails/acr/alertmail');
    }
}
