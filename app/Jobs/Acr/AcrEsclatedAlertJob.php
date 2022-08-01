<?php

namespace App\Jobs\Acr;

use App\Jobs\Acr\MakeAcrPdfOnSubmit;
use App\Mail\Acr\AcrEsclatedMail;
use App\Models\Acr\Acr;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Log;

class AcrEsclatedAlertJob implements ShouldQueue
{
    public $acr;
    public $dutyType;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Acr $acr,$dutyType)
    {
        $this->acr = $acr;
        $this->dutyType = $dutyType;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dutyType=$this->dutyType;
        dispatch(new MakeAcrPdfOnSubmit($this->acr, $dutyType));
        $defaulterEmployee = $this->acr->userOnBasisOfDuty($dutyType);
        $mail = Mail::to($defaulterEmployee);
        $mail->cc(['er_manojbisht@yahoo.com']);
        $mail->send(new AcrEsclatedMail($this->acr, $defaulterEmployee, $dutyType));
    }
}
