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
     * Create1 means first page od Self Appraisal filled by user
     * for three type it is different 
     */
    public function create1(Acr $acr)
    {
        // Check if Acr have only single Page data 
        if(in_array($acr->acr_type_id, config('acr.basic.acrWithoutProcess'))){
            return view('employee.acr.form.single_page.user_create', compact('acr'));
        }

        // Check if Acr is in IFMS Portal Formate for Ministrial Staff 
        if(in_array($acr->acr_type_id, config('acr.basic.acrIfmsFormat'))){
            $filled_data = $acr->fillednegativeparameters()->get();
            return view('employee.acr.form.ifms_ministerial.user_create', compact('acr','filled_data'));
        }
        // default for Remaining Engineers Formate 
        $data_groups = $acr->type1RequiremntsWithFilledData();
        $page = 1;

        return view('employee.acr.form.create1', compact('acr', 'data_groups', 'page'));
    }
    /**
     * @param Acr     $acr
     * @param Request $request
     */
    public function create2(Acr $acr)
    {
        $page = 2;
        return view('employee.acr.form.create2', compact('acr', 'page'));
    }
    /**
     * @param Acr     $acr
     * @param Request $request
     */
    public function create3(Acr $acr)
    {
        $page = 3;
        $require_negative_parameters = $acr->acrMasterParameters()->where('type', 0)->get()->keyBy('id');

        $filled_negative_parameters = $acr->fillednegativeparameters()->get()->groupBy('acr_master_parameter_id');

        $require_negative_parameters->map(function ($row) use ($filled_negative_parameters) {
            if (isset($filled_negative_parameters[$row->id])) {
                $row->user_filled_data = $filled_negative_parameters[$row->id];
            } else {
                $row->user_filled_data = [];
            }
            return $row;
        });

        $negative_groups = $require_negative_parameters->groupBy('config_group');
        //return $negative_groups;

        return view('employee.acr.form.create3', compact('acr', 'negative_groups', 'page'));
    }
    /**
     * @param Acr     $acr
     * @param Request $request
     */
    public function addTrainningToEmployee(Acr $acr, Request $request)
    {
        $page = 4;
        $master_trainings = AcrMasterTraining::all()->groupBy('topic');

        $selected_trainings = $acr->employee->trainnings->pluck('id');

        return view('employee.acr.form.add_trainning_to_employee', compact('acr', 'master_trainings', 'selected_trainings', 'page'));
    }

     /**
     * @param Acr     $acr
     * @param Request $request
     */
/*    public function createSinglePageAcr(Acr $acr)
    {
        return view('employee.acr.form.createSinglePageAcr', compact('acr'));
    }*/


    public function show(Acr $acr, Request $request)
    {
        $view = true;
        // from Create 1
        $data_groups = $acr->type1RequiremntsWithFilledData();
        // From Create 2
        // From Create 3
        $require_negative_parameters = $acr->acrMasterParameters()->where('type', 0)->get()->keyBy('id');
        $filled_negative_parameters = $acr->fillednegativeparameters()->get()->groupBy('acr_master_parameter_id');
        $require_negative_parameters->map(function ($row) use ($filled_negative_parameters) {
            if (isset($filled_negative_parameters[$row->id])) {
                $row->user_filled_data = $filled_negative_parameters[$row->id];
            } else {
                $row->user_filled_data = [];
            }
            return $row;
        });
        $negative_groups = $require_negative_parameters->groupBy('config_group');

        // From Create 4

        $selected_trainings = $acr->employee->EmployeeProposedTrainings->pluck('training_id');

        $master_trainings = AcrMasterTraining::whereIn('id', $selected_trainings)->get()->groupBy('topic');


        return view('employee.acr.form.show', compact('acr', 'data_groups', 'negative_groups', 'master_trainings', 'selected_trainings', 'view'));
    }

    /**
     * @param Request $request
     */
    public function store1(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);

        foreach ($request->acr_master_parameter_id as $acr_master_parameter) {
            if ($request->applicable[$acr_master_parameter] == 1) { // && ($request->target[$acr_master_parameter] || $request->achivement[$acr_master_parameter] || $request->status[$acr_master_parameter]
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
            if ($request->applicable[$acr_master_parameter] == 0) {
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

        $result = $acr->checkSelfAppraisalFilled();

        if (!$result['status']) {
            return Redirect()->back()->with('fail', 'Please Fill the data or Select NO for Parameters Not Applicable.');
        }


        return redirect()->route('acr.form.create2', compact('acr'))->with('success', 'Part -II Self-Appraisal Page -1 saved successfully');
    }

    /**
     * @param Request $request
     */
    public function store2(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        $acr->update([
            'good_work' => $request->good_work,
            'difficultie' => $request->difficultie
        ]);



        return redirect()->route('acr.form.create3', compact('acr'))->with('success', 'Part -II Self-Appraisal Page -2 saved successfully');
    }

    public function store3(Request $request)
    {
        //return $request->all();
        $acr = Acr::findOrFail($request->acr_id);
        foreach ($request->acr_master_parameter_id as $parameter_id) {
            foreach ($request->$parameter_id as $rowNo => $rowData) {
               if ($rowData['col_1']) {

                    AcrNegativeParameter::UpdateOrCreate(
                        [
                            'acr_id' => $request->acr_id,
                            'acr_master_parameter_id' => $parameter_id ?? '',
                            'row_no' => $rowNo
                        ],
                        [
                            'col_1' => $rowData['col_1'] ?? '',
                            'col_2' => $rowData['col_2'] ?? '',
                            'col_3' => $rowData['col_3'] ?? '',
                            'col_4' => $rowData['col_4'] ?? '',
                            'col_5' => $rowData['col_5'] ?? '',
                            'col_6' => $rowData['col_6'] ?? '',
                            'col_7' => $rowData['col_7'] ?? '',
                            'col_8' => $rowData['col_8'] ?? '',
                            'col_9' => $rowData['col_9'] ?? ''
                        ]
                    );
               }
            }
        }

        return Redirect()->back();
        /*if ($request->final == 0) {
            return Redirect()->back()->with('success', 'Part -II Self-Appraisal Page -3 Data saved successfully');;
        } else {
            return redirect()->route('acr.form.addTrainningToEmployee', compact('acr'))->with('success', 'Part -II Self-Appraisal Page -3 Deduction Parameters saved successfully');
        }*/
    }

    /**
     * @param Request $request
     */
    public function storeTrainning(Request $request)
    {
        $this->validate($request, [
            'training' => 'required|array|between:1,4'
        ]);

        Employee::findOrFail($request->employee_id)->trainnings()->sync($request->training);

        // return redirect()->back()->with('success','trainning details are updated');
        return redirect()->route('acr.myacrs')->with('success', 'Part -II Self-Appraisal Trainning Details are updated successfully');
    }

    public function storeSinglePageAcr(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        $acr->update([
            'good_work' => $request->good_work,
        ]);
        return redirect()->route('acr.myacrs')->with('success', 'Self-Appraisal Details Updated successfully');
    }

    public function storeIfmsAcr(Request $request)
    {

        $acr = Acr::findOrFail($request->acr_id);
          $this->validate(
            $request,
            [
                'service_cadre' => 'required|min:3|max:200',
                'scale' => 'required|min:2|max:200',
                'doj_current_post' => 'required|date',
                //'has_medical_checkUp' => 'required',                
                'medical_certificate_date' => 'required_if:has_medical_checkUp,==,"on"|nullable|date',
                'certificate_file' => 'required_if:has_medical_checkUp,==,"on"',
            ]
        );
       // return $request->all();
        foreach ($request->data as $rowData) {
            //return $rowData;
            if ($rowData['col_1']) {
                AcrNegativeParameter::UpdateOrCreate(
                    [
                        'acr_id' => $request->acr_id,
                        'acr_master_parameter_id' => $request->acr_master_parameter_id,
                        'row_no' => $rowData['row_no']
                    ],
                    [
                        'col_1' => $rowData['col_1'] ?? '',
                        'col_2' => $rowData['col_2'] ?? '',
                        'col_3' => $rowData['col_3'] ?? '',
                        'col_4' => $rowData['col_4'] ?? '',
                        'col_5' => $rowData['col_5'] ?? '',
                        'col_6' => $rowData['col_6'] ?? '',
                        'col_7' => $rowData['col_7'] ?? '',
                        'col_8' => $rowData['col_8'] ?? '',
                        'col_9' => $rowData['col_9'] ?? ''
                    ]
                );
            }
        }


        $acr->update([
            'service_cadre' => $request->service_cadre,
            'scale' => $request->scale,
            'doj_current_post' => $request->doj_current_post,
            'medical_certificate_date' => $request->medical_certificate_date,
        ]);

        if ($request->hasFile('certificate_file')){
            Log::info("certificate_file got ");
            $extension = $request->certificate_file->extension();
            $fileName = $acr->employee_id . '_medical_certificate' . '.' . $extension;
            $path = $request->certificate_file->storeAs('acr/mc' , $fileName, 'public');
            $doc_address=config('site.app_url_mis') . '/' . $path;
            Log::info("doc_address = ".print_r($doc_address,true));
        }
        return redirect()->route('acr.myacrs')->with('success', 'Self-Appraisal Details Updated successfully');
    }

    public function storeIfmsReporting(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        
       // return $request->all();
        foreach ($request->data as $parameter_id=>$values) {
            AcrParameter::UpdateOrCreate(
                [
                    'acr_id' => $request->acr_id,
                    'acr_master_parameter_id' => $parameter_id ?? '',
                    'is_applicable' => 1
                ],
                [
                    'status' => $values['remark'] ?? '',
                    'reporting_marks' => $values['no'] ?? ''
                ]
            );
            
        }
        $acr->update([
            'appraisal_note_1' => $request->reporting_remark,
            'report_no' => $request->reporting_final_marks
        ]);

        return redirect()->route('acr.others.index')->with('success', 'Details Updated successfully');
    }

    public function storeIfmsReview(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        if($acr->isAcrDuetoLoggedUserfor('review')){
            $this->validate($request, ['review_no' => 'required' ]);
        }
        $acr->update([
            'review_remark' => $request->review_remark,
            'review_no' => $request->review_no
        ]); 
          
        return redirect()->route('acr.others.index')->with('success', 'Details Updated successfully');
    }
}
