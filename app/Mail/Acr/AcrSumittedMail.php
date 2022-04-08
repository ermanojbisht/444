<?php

namespace App\Mail\Acr;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Log;

class AcrSumittedMail extends Mailable
{
    public $acr;
    public $msg;
    public $reportingEmployee;
    public $targetDutyType;


    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     * //$msg is false in other cases except acknowledgedNotification
     */
    public function __construct($acr, $reportingEmployee, $targetDutyType,$msg=false)
    {
        //
        $this->acr = $acr;
        $this->msg = $msg;
        $this->reportingEmployee = $reportingEmployee;
        //Log::info("reportingEmployee2222 = ".print_r($reportingEmployee,true));

        $this->targetDutyType = $targetDutyType;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->msg===false){
            return $this->subject('ACR of '.$this->acr->employee->name. '( '.$this->acr->employee_id.' )'.now()->format('d-m-y H:i:s'))
            ->markdown('emails.acr.subittedmail')
            ->attach($this->acr->pdfFullFilePath,['mime'=>'application/pdf']);
        }
        return $this->subject('ACR of '.$this->acr->employee->name. '( '.$this->acr->employee_id.' )'.now()->format('d-m-y H:i:s'))
        ->markdown('emails.acr.subittedmail');


    }
}
