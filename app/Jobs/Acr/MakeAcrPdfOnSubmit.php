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
        //Log::info("in __construct  MakeAcrPdfOnSubmit ");

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
            $this->acr-reportNotification();
        }

        if($this->milstone=='review'){
            $this->acr->reviewNotification();
        }

        if($this->milstone=='accept'){
            $this->acr->acceptNotification();
        }

    }

    public function arrangeAcrView()
    {
        $pages = []; $view = true;
        $acr=$this->acr;
        if(in_array($this->milstone, ['submit','report','review','accept'])){
            list($employee, $appraisalOfficers, $leaves, $appreciations, $inbox, $reviewed, $accepted) = $this->acr->firstFormData();
            $pages[] = view('employee.acr.view_part1', ['acr'=>$this->acr, 'employee'=> $employee,'appraisalOfficers' => $appraisalOfficers, 'leaves'=> $leaves, 'appreciations'=>$appreciations, 'inbox' => $inbox, 'reviewed' => $reviewed, 'accepted' => $accepted ]);

        $acr =$this->acr;
            // from Create 1
            $data_groups=$acr->type1RequiremntsWithFilledData();
            // From Create 2
            // From Create 3
            $require_negative_parameters=$acr->acrMasterParameters()->where('type',0)->get()->keyBy('id');
            $filled_negative_parameters=$acr->fillednegativeparameters()->get()->groupBy('acr_master_parameter_id');
            $require_negative_parameters->map(function($row) use ($filled_negative_parameters){
                if(isset($filled_negative_parameters[$row->id])){
                    $row->user_filled_data=$filled_negative_parameters[$row->id];
                }else{
                    $row->user_filled_data=[];
                }
                return $row;
            });
            $negative_groups = $require_negative_parameters->groupBy('config_group');

            // From Create 4

            $selected_trainings = $acr->employee->EmployeeProposedTrainings->pluck('training_id');
            
            $master_trainings = AcrMasterTraining::whereIn('id', $selected_trainings)->get()->groupBy('topic');
            
            
            $pages[] =  view('employee.acr.form.show',compact('acr','data_groups','negative_groups','master_trainings','selected_trainings','view'));
        }

        //acr form by user ?//todo
        $errors=collect([]);
        if(in_array($this->milstone, ['report','review','accept'])){
            $requiredParameters = $this->acr->type1RequiremntsWithFilledData()->first();
            $requiredNegativeParameters = $this->acr->type2RequiremntsWithFilledData();
            $personal_attributes=  $this->acr->peronalAttributeSWithMasterData();

            if(in_array($this->milstone, ['review','accept'])){
                $pages[] = view('employee.acr.form.appraisal2',compact('acr','requiredParameters','personal_attributes','requiredNegativeParameters','view','errors'));
            }

             if($this->milstone=='report'){
                $pages[] =view('employee.acr.form.appraisal',compact('acr','requiredParameters','personal_attributes','requiredNegativeParameters','view','errors'));
            }

        }

        if($this->milstone=='accept'){
            //todo
        }




        $this->pdf = \App::make('snappy.pdf.wrapper');
        $this->pdf->setOption('margin-top',5);
        $this->pdf->setOption('cover', view('employee.acr.pdfcoverpage', ['acr'=>$this->acr]));
        $this->pdf->setOption('footer-html',  view('employee.acr.pdffooter'));
        $this->pdf->loadHTML($pages);
    }
}
