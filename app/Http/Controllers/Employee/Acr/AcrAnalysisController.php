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
                $data['submitt days'][$days][] = $acr->id;
                
            }
            if($acr->report_on){
                $days = Carbon::parse( $acr->report_on )->diffInDays( $acr->submitted_at); 
                $data['report days'][$days][] = $acr->id;
            }
            if($acr->review_on){
                $days = Carbon::parse( $acr->report_on )->diffInDays( $acr->review_on); 
                $data['review days'][$days][] = $acr->id;
            }
            if($acr->accept_on){
                $days = Carbon::parse( $acr->accept_on )->diffInDays( $acr->review_on); 
                $data['accept days'][$days][] = $acr->id;
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

    public function marksChart(Request $request)
    {
        $acr_data = Acr::where('acr_type_id','>',0)->where('is_active',1)->where('final_no','>',0)->get();

        $acr_marks = $acr_data->map(function ($acr) {
                if($acr->final_no <= 10){
                    return $acr->final_no*10;
                }else{
                    return $acr->final_no*1;
                }
            });
        $total = count($acr_marks);
        $step = 5;
        $min = round(($acr_marks->min()/$step),0)*$step;
        $max = 100;
        $columns = ceil(($max- $min)/$step);
        $data = [];
        $start = $min;
        for ($i=0; $i < $columns; $i++) { 
            
            $end = $start + $step;

            $range_data = array_filter($acr_marks->toArray(), function($n) use($start,$end){ 
                return $n > $start && $n <= $end;
            });

            $count = count($range_data);

            if(count($range_data)){
                $average = array_sum($range_data) / count($range_data);
            }else{
                $average = $start;
            }

            if($start >= 80){
                $color = "#01C153";
            }elseif($start >= 60){
                $color = "#89D358";
            }elseif($start >= 40){
                $color = "#DCF53D";
            }else{
                $color = "#ff0000";
            }

            $percent =  round(count($range_data)*100/$total,0);

            $data[] = [ 'start'=>$start, 
                        'end'=>$end,
                        'range'=> $start.'-'.$end,
                        'step'=>$step,
                        'count'=>$count,
                        'color'=>$color,
                        'average'=>round($average,1),
                        'percent'=>$percent,
                    ];
            $start = $end;
        }
       //return $data;
       // return  $acr_data->avg();
        return view('employee.acr.marksChart', compact('data'));
      
    }
}
