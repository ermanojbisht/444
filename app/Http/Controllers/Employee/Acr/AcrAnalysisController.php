<?php

namespace App\Http\Controllers\Employee\Acr;

use App\Http\Controllers\Controller;
use App\Models\Acr\EmpProposedTraining;
use App\Models\Acr\AcrMasterTraining;
use App\Models\Acr\Acr;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AcrAnalysisController extends Controller
{
    public function trainningRequirementChart()
    {
        
        $tranings = AcrMasterTraining::all()->keyBy('id');
        
        $training_data = EmpProposedTraining::all();
        
        $employees = $training_data->pluck('employee_id')->unique()->count();
        
        $training_nos = $training_data->groupBy('training_id')->map(function($row){
            return $row->count();
        })->sortDesc();

        //$top_training = array_keys($training_nos->take(5)->toArray());

        return view('employee.acr.trainningRequirementChart', compact('training_nos','tranings', 'employees'));
    }

    public function trainningRequirementDetail($trainingId)
    {
         $tranings = AcrMasterTraining::all()->keyBy('id');

         $employees =  EmpProposedTraining::with(['employee','employee.designation'])->where('training_id',$trainingId)->get();

        return view('employee.acr.trainningRequirementDetail', compact('employees', 'tranings', 'trainingId'));
      
    }

    public function daysChart()
    {
         $acr_data = Acr::where('acr_type_id','>',0)->where('is_active',1)->select('id','created_at','submitted_at','report_on','review_on','accept_on')->get();
         $data = [];
         
         foreach ($acr_data as $acr) {
            if($acr->submitted_at){
                $days = Carbon::parse( $acr->created_at )->diffInDays( $acr->submitted_at); 
                $data['submitt_days'][$days][] = $acr->id;
                
            }
            if($acr->report_on){
                $days = Carbon::parse( $acr->report_on )->diffInDays( $acr->submitted_at); 
                $data['report_days'][$days][] = $acr->id;
            }
            if($acr->review_on){
                $days = Carbon::parse( $acr->report_on )->diffInDays( $acr->review_on); 
                $data['review_days'][$days][] = $acr->id;
            }
            if($acr->accept_on){
                $days = Carbon::parse( $acr->accept_on )->diffInDays( $acr->review_on); 
                $data['accept_days'][$days][] = $acr->id;
            }
         }
       // return array_keys($data['submitt_days']);
        //return $data;
        /*return  array_sum($data['submitt_days'])/count($data['submitt_days']);
        //return  array_sum($data['report_days'])/count($data['report_days']);
        //return  array_sum($data['review_days'])/count($data['review_days']);
        return  array_sum($data['accept_days'])/count($data['accept_days']);*/
        return view('employee.acr.daysChart', compact('data'));
      
    }
}
