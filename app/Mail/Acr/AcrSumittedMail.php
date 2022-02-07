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
    public $reportingEmployee;
    public $targetDutyType;


    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($acr, $reportingEmployee, $targetDutyType)
    {
        //
        $this->acr = $acr;
        $this->reportingEmployee = $reportingEmployee;
        //Log::info("reportingEmployee = ".print_r($reportingEmployee,true));

        $this->targetDutyType = $targetDutyType;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(now()->format('d-m-y').' ACR of '.$this->acr->employee->name. '( '.$this->acr->employee_id.' )')
        ->markdown('emails.acr.subittedmail')
        ->attach($this->acr->pdfFullFilePath,['mime'=>'application/pdf']);;
    }
}
