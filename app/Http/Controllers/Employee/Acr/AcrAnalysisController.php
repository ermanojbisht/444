<?php

namespace App\Http\Controllers\Employee\Acr;

use App\Http\Controllers\Controller;
use App\Models\Acr\EmpProposedTraining;
use Illuminate\Http\Request;

class AcrAnalysisController extends Controller
{
    public function trainningRequirementChart()
    {
        $chartData = EmpProposedTraining::with('trainning')->get()->groupBy('trainning.description')->map(function($row){
            return $row->count();
        })->sortDesc();
        $data = [];
        foreach ($chartData as $key => $value) {
             $data[] = ['name'=> $key, 'value'=> $value];
        }
        //return $data;
        return view('employee.acr.trainningRequirementChart', compact('data'));
    }

    public function trainningRequirementDetail($trainingId)
    {
        return EmpProposedTraining::with(['employee','employee.designation'])->where('training_id',$trainingId)->get();
      
    }
}
