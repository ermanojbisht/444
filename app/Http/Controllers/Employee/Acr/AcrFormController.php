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

class AcrFormController extends Controller
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
    public function create1(Acr $acr, Request $request)
    {
        $data_groups=$acr->type1RequiremntsWithFilledData();
        return view('employee.acr.form.create1',compact('acr','data_groups'));
    }
    /**
     * @param Acr     $acr
     * @param Request $request
     */
    public function create2(Acr $acr, Request $request)
    {
        return view('employee.acr.form.create2',compact('acr'));
    }
    /**
     * @param Acr     $acr
     * @param Request $request
     */
    public function create3(Acr $acr, Request $request)
    {

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
        //return $negative_groups;
        
        return view('employee.acr.form.create3',compact('acr','negative_groups'));
    }
    /**
     * @param Acr     $acr
     * @param Request $request
     */
    public function create4(Acr $acr, Request $request)
    {
        $master_trainings = AcrMasterTraining::all()->groupBy('topic');
        
        $selected_trainings = $acr->employee->EmployeeProposedTrainings->pluck('training_id');
        
        return view('employee.acr.form.create4',compact('acr','master_trainings','selected_trainings'));
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


    /**
     * @param Request $request
     */
    public function store1(Request $request)
    {
        foreach ($request->acr_master_parameter_id as $acr_master_parameter) {
            if ($request->applicable[$acr_master_parameter] == 1 && ($request->target[$acr_master_parameter] || $request->achivement[$acr_master_parameter] || $request->status[$acr_master_parameter])) {             
                AcrParameter::UpdateOrCreate(
                    [
                        'acr_id' => $request->acr_id,
                        'acr_master_parameter_id' => $acr_master_parameter
                    ],
                    [
                        'user_target' => $request->target[$acr_master_parameter] ?? '',
                        'user_achivement' => $request->achivement[$acr_master_parameter] ?? '',
                        'status' => $request->status[$acr_master_parameter] ?? '',
                        'is_applicable' => $request->applicable[$acr_master_parameter]
                    ]
                );
            }
            if($request->applicable[$acr_master_parameter] == 0){
                 AcrParameter::UpdateOrCreate(
                    [
                        'acr_id' => $request->acr_id,
                        'acr_master_parameter_id' => $acr_master_parameter
                    ],
                    [
                        'user_target' => '',
                        'user_achivement' => '',
                        'status' => '',
                        'is_applicable' => $request->applicable[$acr_master_parameter]
                    ]
                );
            }
        }
         return redirect()->back();
        //return redirect()->route('acr.form.create2',compact('acr'))->with('success','data in Form 1 saved successfully');
    }

    /**
     * @param Request $request
     */
    public function store2(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        $acr->update(['good_work' => $request->good_work,
            'difficultie' => $request->difficultie]);
        //$acr->save();

        return redirect()->back();
    }

    public function store3(Request $request)
    {
        //return $request->all();
        foreach ($request->acr_master_parameter_id as $parameter_id) {
            foreach($request->$parameter_id as $rowNo=> $rowData){
                if ($rowData['col_1'] ){

                    AcrNegativeParameter::UpdateOrCreate(
                        [
                            'acr_id' => $request->acr_id,
                            'acr_master_parameter_id' => $parameter_id??'',
                            'row_no' => $rowNo
                        ],
                        [
                            'col_1' => $rowData['col_1']??'',
                            'col_2' => $rowData['col_2']??'',
                            'col_3' => $rowData['col_3']??'',
                            'col_4' => $rowData['col_4']??'',
                            'col_5' => $rowData['col_5']??'',
                            'col_6' => $rowData['col_6']??'',
                            'col_7' => $rowData['col_7']??'',
                            'col_8' => $rowData['col_8']??'',
                            'col_9' => $rowData['col_9']??''
                        ]
                    );
                }
            }
        }

        return redirect()->back();
    }

    /**
     * @param Request $request
     */
    public function store4(Request $request)
    {
        $this->validate($request,[
            'training' => 'required|array|between:1,4'
        ]);

        // delete all previou record
        //$deleted = EmpProposedTraining::where('employee_id', $request->employee_id)->firstorfail()->delete();
        //return $request->all();
        $employee = Employee::findOrFail($request->employee_id);
        foreach ($request->training as $training) {
            EmpProposedTraining::Create(
                    [
                        'employee_id' => $request->employee_id,
                        'training_id' => $training,
                    ]
                );

        }
        
        //$acr->save();

        return redirect()->back();
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
                if(config('acr.group')[$groupId]['multi_rows']){
                    foreach ($AcrParameter as $Parameter) {
                        foreach (config('acr.group')[$groupId]['columns'] as $key=>$columns) {
                            if( $columns['input_type'] === false){

                            }else{
                                $text[] = "<p>";
                                $text[] = "<span class='fs-5 fw-semibold'> ".$columns['text']."</span> : ";
                                $text[] = "<span class='fs-5 fw-bold text-info'> ".$Parameter[$columns['input_name']]."</span>";
                                $text[] = "</p>";

                            }
                        }
                        $text[] = "<hr>";
                    }
                    
                }else{
                    // Single Row Data
                    foreach (config('acr.group')[$groupId]['columns'] as $key=>$columns) {
                        $text[] = "<p>";
                        $text[] = "<span class='fs-5 fw-semibold'> ".$columns['text']."</span> : ";
                        $text[] = "<span class='fs-5 fw-bold text-info'> ".$AcrParameter[0][$columns['input_name']]."</span>";
                        $text[] = "</p>";
                    }
                }
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
