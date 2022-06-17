<?php

namespace App\Http\Controllers\Employee\Acr;

use App\Http\Controllers\Controller;
use App\Models\Acr\EmpProposedTraining;
use App\Models\Acr\AcrMasterTraining;
use Illuminate\Http\Request;

class AcrAnalysisController extends Controller
{
    public function trainningRequirementChart()
    {
        
        $tranings = AcrMasterTraining::all()->keyBy('id');
        
        $training_nos = EmpProposedTraining::all()->groupBy('training_id')->map(function($row){
            return $row->count();
        })->sortDesc();

        $top_training = array_keys($training_nos->take(12)->toArray());

        return view('employee.acr.trainningRequirementChart', compact('training_nos','tranings', 'top_training'));
    }

    public function trainningRequirementDetail($trainingId)
    {
         $tranings = AcrMasterTraining::all()->keyBy('id');

         $employees =  EmpProposedTraining::with(['employee','employee.designation'])->where('training_id',$trainingId)->get();

        return view('employee.acr.trainningRequirementDetail', compact('employees', 'tranings', 'trainingId'));
      
    }
}
