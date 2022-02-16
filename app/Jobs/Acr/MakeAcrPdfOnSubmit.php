<?php

namespace App\Jobs\Acr;

use App\Models\Acr\Acr;
use App\Models\Acr\AcrMasterTraining;
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
    public $pdf;
    public $milstone;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Acr $acr,$milstone)
    {
        //Log::info("in __construct  MakeAcrPdfOnSubmit milstone $milstone");

        $this->acr = $acr;
        $this->milstone = $milstone;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {


        $this->arrangeAcrView();

        $this->acr->createPdfFile($this->pdf,true);

        if($this->milstone=='submit'){
            $this->acr->submitNotification();
        }

        if($this->milstone=='report'){
            $this->acr->reportNotification();
        }

        if($this->milstone=='review'){
            $this->acr->reviewNotification();
        }

        if($this->milstone=='accept'){
            $this->acr->acceptNotification();
        }

        if($this->milstone=='reject'){
            $this->acr->rejectNotification();
        }

    }

    public function arrangeAcrView()
    {
        $pages = []; $view = true;
        $acr=$this->acr;
        if(in_array($this->milstone, ['submit','report','review','accept','reject'])){
            list($employee, $appraisalOfficers, $leaves, $appreciations, $inbox, $reviewed, $accepted,$officeWithParentList,$acr_selected_group_type, $acr_types) = $this->acr->firstFormData();
            $pages[] = view('employee.acr.view_part1', ['acr'=>$this->acr, 'employee'=> $employee,'appraisalOfficers' => $appraisalOfficers, 'leaves'=> $leaves, 'appreciations'=>$appreciations, 'inbox' => $inbox, 'reviewed' => $reviewed, 'accepted' => $accepted ,'officeWithParentList'=>$officeWithParentList,'acr_selected_group_type'=>$acr_selected_group_type,'acr_types'=>$acr_types]);

            // from Create 1
            $data_groups=$acr->type1RequiremntsWithFilledData();
            // From Create 2
            // From Create 3
            $negative_groups = $acr->negative_groups();
            // From Create 4
            $selected_trainings = $acr->employee->EmployeeProposedTrainings->pluck('training_id');
            
            $master_trainings = AcrMasterTraining::whereIn('id', $selected_trainings)->get()->groupBy('topic');
            
            $pages[] =  view('employee.acr.form.show',compact('acr','data_groups','negative_groups','master_trainings','selected_trainings','view'));
        }

        //acr form by user ?//todo
        //$errors=collect([]);
        if(in_array($this->milstone, ['report','review','accept'])){

            if($acr->isSinglePage){
                $pages[] = view('employee.acr.form.appraisalShowSinglePage', compact('acr'));
            }else{

                $requiredParameters = $this->acr->type1RequiremntsWithFilledData()->first();
                $requiredNegativeParameters = $this->acr->type2RequiremntsWithFilledData();
                $personal_attributes=  $this->acr->peronalAttributeSWithMasterData();


                $pages[] = view('employee.acr.form.appraisalShow',compact('acr','requiredParameters','personal_attributes','requiredNegativeParameters'));
            }
            //integirty view
            $pages[] = view('employee.other_acr.view_reported_acr', compact('acr'));

        }

        if($this->milstone=='accept'){
            $pages[] =view('employee.other_acr.view_accepted_acr', compact('acr'));
        }

        $this->pdf = \App::make('snappy.pdf.wrapper');
        $this->pdf->setOption('margin-top',15);
        $this->pdf->setOption('cover', view('employee.acr.pdfcoverpage', ['acr'=>$this->acr]));
        $this->pdf->setOption('footer-html',  view('employee.acr.pdffooter'));
        $this->pdf->loadHTML($pages);
    }
}
