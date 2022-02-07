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
        $page = 1;
        $view = false;
        return view('employee.acr.form.create1',compact('acr','data_groups','page','view'));
    }
    /**
     * @param Acr     $acr
     * @param Request $request
     */
    public function create2(Acr $acr, Request $request)
    {
        $page = 2;
        $view = false;
        return view('employee.acr.form.create2',compact('acr','page','view'));
    }
    /**
     * @param Acr     $acr
     * @param Request $request
     */
    public function create3(Acr $acr, Request $request)
    {
        $page = 3;
        $view = true;
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
        
        return view('employee.acr.form.create3',compact('acr','negative_groups','page','view'));
    }
    /**
     * @param Acr     $acr
     * @param Request $request
     */
    public function create4(Acr $acr, Request $request)
    {
        $page = 4;
        $view = true;
        $master_trainings = AcrMasterTraining::all()->groupBy('topic');
        
        $selected_trainings = $acr->employee->EmployeeProposedTrainings->pluck('training_id');
        
        return view('employee.acr.form.create4',compact('acr','master_trainings','selected_trainings','page','view'));
    }

    public function show(Acr $acr, Request $request)
    {
        $view = true;
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
        
        
        return view('employee.acr.form.show',compact('acr','data_groups','negative_groups','master_trainings','selected_trainings','view'));
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

}
