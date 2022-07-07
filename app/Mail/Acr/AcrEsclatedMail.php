<?php

namespace App\Mail\Acr;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Log;

class AcrEsclatedMail extends Mailable
{
    public $acr;
    public $defaulterEmployee;
    public $dutyType;


    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     * //$msg is false in other cases except acknowledgedNotification
     */
    public function __construct($acr, $defaulterEmployee, $dutyType)
    {
        $this->acr = $acr;
        $this->defaulterEmployee = $defaulterEmployee;
        $this->dutyType = $dutyType;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->subject('Esclated ACR of '.$this->acr->employee->name. '( '.$this->acr->employee_id.' )'.now()->format('d-m-y H:i:s'))
        ->markdown('emails.acr.esclatedmail');

    }
}
