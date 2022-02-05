<?php

namespace App\Jobs\Acr;

use App\Models\Acr\Acr;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class MakeAcrPdfOnSubmit implements ShouldQueue
{
    public $acr;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Acr $acr)
    {
        $this->acr = $acr;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        $pages = array();
        list($employee, $appraisalOfficers, $leaves, $appreciations, $inbox, $reviewed, $accepted) = $this->acr->firstFormData();

        $pages[] = view('employee.acr.view_part1', ['acr'=>$this->acr,
        'employee'=> $employee,'appraisalOfficers' => $appraisalOfficers, 'leaves'=> $leaves, 
        'appreciations'=>$appreciations, 'inbox' => $inbox, 'reviewed' => $reviewed, 'accepted' => $accepted ]);

        $pdf = \App::make('snappy.pdf.wrapper');
        $pdf->setOption('margin-top',5);
        $pdf->setOption('cover', view('employee.acr.pdfcoverpage', ['acr'=>$this->acr]));
        $pdf->setOption('footer-html',  view('employee.acr.pdffooter'));
        $pdf->loadHTML($pages);

        $this->acr->createPdfFile($pdf,true);
        $this->acr->submitNotification();
    }
}
