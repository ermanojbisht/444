<?php

namespace App\Http\Controllers\Employee\Acr; 

use App\Http\Controllers\Controller; 
use App\Models\Acr\Acr;
use App\Models\Acr\AcrNegativeParameter;
use App\Models\Acr\AcrParameter;
use App\Models\Acr\AcrMasterTraining;
use App\Models\Acr\AcrMasterParameter;
use App\Models\Acr\EmpProposedTraining;
use App\Models\Acr\AcrMasterPersonalAttributes;

use App\Models\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  
use Log;

class AcrReportController extends Controller
{
 
    /**
     * @var mixed
     */
    protected $user;

    /**
     * @return mixed
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // abort_if(Gate::denies('track_estimate'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $this->user = Auth::User();
            return $next($request);
        });
    }


    /**
     * @param Acr     $acr
     * @param Request $request
     */
    public function appraisal1(Acr $acr, Request $request)
    {
        $requiredParameters=$acr->acrMasterParameters()->where('type',1)->get();
        
        $notApplicableParameters=$acr->filledparameters()->where('is_applicable',0)->get()->pluck('acr_master_parameter_id');
        //$data_groups = $requiredParameters->groupBy('config_group');

        $personal_attributes=  AcrMasterPersonalAttributes::all();
        
        $requiredNegativeParameters=$acr->acrMasterParameters()->where('type',0)->get();
        
        return view('employee.acr.form.appraisal',compact('acr','requiredParameters','notApplicableParameters','personal_attributes','requiredNegativeParameters'));
    }


    public function storeAppraisal1(Request $request)
    {
        return $request->all();
        $acr = Acr::findOrFail($request->acr_id);
        $acr->update([
            'appraisal_note_1' => $request->appraisal_note_1,
            'appraisal_note_2' => $request->appraisal_note_2,
            'appraisal_note_3' => $request->appraisal_note_3
        ]);
        //$acr->save();

        return redirect()->back();
    }

    public function getUserParameterData($acrId, $paramId)
    {   

        $AcrMasterParameter =  AcrMasterParameter::where('id',$paramId)->first();
       
        $AcrParameter =  AcrParameter::where('acr_master_parameter_id',$paramId)->where('acr_id',$acrId)->first();

        $text = [];
        $text[] = "<p class='fs-5 fw-semibold my-0'>User Input For </p>";
        $text[] = "<p class='text-info fs-5 fw-bold'>".$AcrMasterParameter->description."</p>";
        if(isset($AcrParameter)){
            if($AcrParameter->is_applicable == 1){
                if($AcrMasterParameter->config_group == 1001){
                    $text[] = "<p class='fs-5 fw-semibold'> Target : ".($AcrParameter->user_target??'')." ".$AcrMasterParameter->unit."</p>";
                    $text[] = "<p class='fs-5 fw-semibold'> Achivement : ".($AcrParameter->user_achivement??'')." ".$AcrMasterParameter->unit."</p>";
                }elseif($AcrMasterParameter->config_group == 1002){
                     $text[] = "<p class='fs-5 fw-semibold'> status : ".$AcrParameter->status."</p>";
                }else{
                    
                }
            }elseif($AcrParameter->is_applicable == 0){
                    $text[] = "<p class='fs-5 fw-semibold text-danger'> User Declare it as Not Applicable</p>";

            }else{

            }   
        }else{
            $text[] = "<p class='fs-5 fw-semibold text-danger'> User not Filled any Data</p>";
        }

        return $text;

    }

    public function getUserNegativeParameterData($acrId, $paramId)
    {   
        $text = [];
        
        $AcrMasterParameter =  AcrMasterParameter::where('id',$paramId)->first();
        
        $groupId = $AcrMasterParameter->config_group;
       
        $AcrParameter =  AcrNegativeParameter::where('acr_master_parameter_id',$paramId)->where('acr_id',$acrId)->get();
        
        $text[] = "<p class='fs-5 fw-semibold my-0'>User Input For </p>";
        $text[] = "<p class='text-info fs-5 fw-bold'>".$AcrMasterParameter->description."</p>";
       
        if(isset($AcrParameter)){
            if($groupId > 2000 && $groupId < 3000){
                $text[] = '<table>';
                    $text[] = '<thead>';
                        $text[] = '<tr>';
                            foreach (config('acr.group')[$groupId]['columns'] as $key=>$columns) {
                                $text[] = '<th>'.$columns['text'].'</th>';        
                            }
                        $text[] = '</tr>';
                    $text[] = '</thead>';
                    $text[] = '<tbody>';
                        foreach ($AcrParameter as $Parameter) {
                            $text[] = '<tr>';
                            foreach (config('acr.group')[$groupId]['columns'] as $key=>$columns) {
                                if( $columns['input_type'] === false){
                                    $text[] = '<td>Sl no</td>';
                                }else{
                                    $text[] = '<td>'.$Parameter[$columns['input_name']].'</td>';
                                }
                            }
                            $text[] = "</tr>";
                        }
                    $text[] = "</tbody>";
                $text[] = "</table>";
            }
            elseif($groupId > 3000){
                    $text[] = "<p class='fs-5 fw-semibold text-danger'>to be develop</p>";
            }
        }else{
            $text[] = "<p class='fs-5 fw-semibold text-danger'> User not Filled any Data</p>";
        }
        return $text;

    }

}
