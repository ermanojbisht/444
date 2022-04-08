<?php

namespace App\Jobs\Acr;

use App\Traits\Acr\AcrPdfArrangeTrait;
use App\Models\Acr\Acr;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class MakeAcrPdfOnSubmit implements ShouldQueue
{
    use AcrPdfArrangeTrait;
    /**
     * @var mixed
     */
    public $acr;
    /**
     * @var mixed false for all cases accept acknowledge
     */
    public $acknowledgeMsg;
    /**
     * @var mixed
     */
    public $pdf;
    /**
     * @var mixed
     */
    public $milestone;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Acr $acr, $milestone,$acknowledgeMsg=false)
    {
        //Log::info("in __construct  MakeAcrPdfOnSubmit milestone= $milestone");
        //Log::info("in __construct  MakeAcrPdfOnSubmit acknowledgeMsg= $acknowledgeMsg");

        $this->acr = $acr;
        $this->acknowledgeMsg = $acknowledgeMsg;
        $this->milestone = $milestone;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        if($this->acknowledgeMsg===false){
            $this->arrangeAcrView();
            $this->acr->createPdfFile($this->pdf, true);
        }


        if ($this->milestone == 'acknowledge') {
            $this->acr->acknowledgedNotification($this->acknowledgeMsg);
        }

        if ($this->milestone == 'submit') {
            $this->acr->submitNotification();
        }

        if ($this->milestone == 'report') {
            $this->acr->reportNotification();
        }

        if ($this->milestone == 'review') {
            $this->acr->reviewNotification();
        }

        if ($this->milestone == 'accept') {
            $this->acr->acceptNotification();
        }

        if ($this->milestone == 'correctnotice') {
            $this->acr->correctnoticeNotification();
        }

        if ($this->milestone == 'reject') {
            //Log::info("in /var/www/444/app/Jobs/Acr/MakeAcrPdfOnSubmit.php ---reject");
            $this->acr->rejectNotification();
        }
    }

    public function arrangeAcrView()
    {
        $pages = $this->arrangePagesForPdf($this->acr, $this->milestone);

        $this->pdf = \App::make('snappy.pdf.wrapper');
        $this->pdf->setOption('margin-top', 10);
        $this->pdf->setOption('cover', view('employee.acr.pdfcoverpage', ['acr' => $this->acr]));
        $this->pdf->setOption('footer-html', view('employee.acr.pdffooter'));
        $this->pdf->setOption('header-html', view('employee.acr.pdfheader'));
        $this->pdf->loadHTML($pages);
    }
}
