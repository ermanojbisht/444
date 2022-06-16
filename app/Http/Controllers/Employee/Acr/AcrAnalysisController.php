<?php

namespace App\Http\Controllers\Employee\Acr;

use App\Http\Controllers\Controller;
use App\Models\Acr\EmpProposedTraining;
use Illuminate\Http\Request;

class AcrAnalysisController extends Controller
{
    public function trainningRequirementChart()
    {
        return EmpProposedTraining::with('trainning')->get()->groupBy('trainning.description')->map(function($row){
            return $row->count();
        })->sort();
    }

    public function trainningRequirementDetail($trainingId)
    {
        return EmpProposedTraining::with('employee')->where('training_id',$trainingId)->get();
      
    }
}
