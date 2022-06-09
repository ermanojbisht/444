<?php

namespace App\Http\Controllers\Employee\OthersAcr;

use App\Http\Controllers\Controller;
use App\Jobs\Acr\MakeAcrPdfOnSubmit;
use App\Models\Acr\Acr;
use App\Models\Acr\AcrNegativeParameter;
use App\Models\Acr\AcrParameter;
use App\Models\Acr\AcrMasterTraining;
use App\Models\Acr\AcrMasterParameter;
use App\Models\Acr\EmpProposedTraining;
use App\Models\Acr\AcrMasterPersonalAttributes;
use App\Models\Acr\AcrPersonalAttribute;

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
    protected $msg403 = 'Unauthorized action.You are not authorised to see this ACR details';

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
     * appraisal1 means first page od Reporting Officer
     * for three type it is different 
     */
    public function appraisal1(Acr $acr, Request $request)
    {
        abort_if($this->user->employee_id <> $acr->report_employee_id, 403, $this->msg403);
        // Check if Acr have only single Page data 
        if($acr->isSinglePage){
            return view('employee.acr.form.single_page.report_create', compact('acr'));
        }

        // Check if Acr is in IFMS Portal Formate for Ministrial Staff 
        if(in_array($acr->acr_type_id, config('acr.basic.acrIfmsFormat'))){
            $filled_data = $acr->fillednegativeparameters()->get();
            $acr_master_parameter = $acr->acrMasterParameters()->get();
            return view('employee.acr.form.ifms_ministerial.report_create', compact('acr','filled_data','acr_master_parameter'));
        }
        // default for Remaining Engineers Formate 
        $requiredParameters = $acr->type1RequiremntsWithFilledData()->first();
        
        $applicableParameters = $requiredParameters->where('applicable',1)->count();

        if($applicableParameters == 0 ){
            $exceptional_reporting_marks = $requiredParameters->sum('reporting_marks');
        }else{
            $exceptional_reporting_marks = 0;
        }   

        $requiredNegativeParameters = $acr->type2RequiremntsWithFilledData();
        
        $personal_attributes =  $acr->peronalAttributeSWithMasterData();
        
        
        return view('employee.acr.form.appraisal', compact('acr', 'requiredParameters', 'personal_attributes', 'requiredNegativeParameters', 'applicableParameters','exceptional_reporting_marks')); //'notApplicableParameters',
    }

    public function show(Acr $acr, Request $request)
    {
        if($acr->isSinglePage){
            return view('employee.acr.form.single_page.report_review_show', compact('acr'));
        }

        $requiredParameters = $acr->type1RequiremntsWithFilledData()->first();
        
        $applicableParameters = $requiredParameters->where('applicable',1)->count();

        if($applicableParameters == 0 ){
            $exceptional_reporting_marks = $requiredParameters->sum('reporting_marks');
            $exceptional_reviewing_marks = $requiredParameters->sum('reviewing_marks');
        }else{
            $exceptional_reporting_marks = $exceptional_reviewing_marks = 0;
        }   
        $requiredNegativeParameters = $acr->type2RequiremntsWithFilledData();
        $personal_attributes =  $acr->peronalAttributeSWithMasterData();

        return view('employee.acr.form.appraisalShow', compact('acr', 'requiredParameters', 'personal_attributes', 'requiredNegativeParameters','applicableParameters','exceptional_reporting_marks','exceptional_reviewing_marks'));
    }


    public function storeAppraisal1(Request $request)
    {

        $this->validate($request,
            [
                'reporting_marks_positive'=> 'array',
                'reporting_marks_positive.*' => 'numeric | nullable',
                'positive_factor'=>'numeric',
                'reporting_marks_negative'=> 'array',
                'reporting_marks_negative.*' => 'numeric | nullable',
                'personal_attributes'=> 'array',
                'personal_attributes.*' => 'numeric | nullable',
                'appraisal_note_1' => 'nullable',
                'appraisal_note_2' => 'nullable',
                'appraisal_note_3' => 'nullable',
            ]
        );

        $acr = Acr::findOrFail($request->acr_id);


        $report_no = 0;

        if($request->positive_factor > 0){ // if altlest a parameter applicable 
            foreach ($request->reporting_marks_positive as $parameterId => $reporting_mark_positive) {
                $report_no = $report_no + $reporting_mark_positive * $request->positive_factor;
                AcrParameter::UpdateOrCreate(
                    [
                        'acr_id' => $request->acr_id,
                        'acr_master_parameter_id' => $parameterId,
                    ],
                    [
                        'reporting_marks' => $reporting_mark_positive,
                    ]
                );
            }
        }else{ // if no parameter applicable
            $first = AcrParameter::where('acr_id',$request->acr_id)->first();
            $first->Update(
                ['reporting_marks' => $request->exceptional_reporting_marks]
            );
            $report_no = $request->exceptional_reporting_marks;
        }

        foreach ($request->personal_attributes as $attributeId => $attribute_mark) {
            $report_no = $report_no + $attribute_mark*1;

            AcrPersonalAttribute::UpdateOrCreate(
                [
                    'acr_id' => $request->acr_id,
                    'personal_attribute_id' => $attributeId,
                ],
                [
                    'reporting_marks' => $attribute_mark,
                ]
            );
        }

        foreach ($request->reporting_marks_negative as $parameterId => $reporting_mark_negative) {
            $report_no = $report_no - $reporting_mark_negative*1;

            AcrParameter::UpdateOrCreate(
                [
                    'acr_id' => $request->acr_id,
                    'acr_master_parameter_id' => $parameterId,
                ],
                [
                    'reporting_marks' => $reporting_mark_negative,
                ]
            );
        }

        $acr->update([
            'appraisal_note_1' => $request->appraisal_note_1,
            'appraisal_note_2' => $request->appraisal_note_2,
            'appraisal_note_3' => $request->appraisal_note_3,
            'report_no' => $report_no,
        ]);
        
       // return $request->all(); 

        return redirect()->back();
    }

    public function storeAcrWithoutProcess(Request $request){

        $acr = Acr::findOrFail($request->acr_id);
        $acr->update([
            'appraisal_note_1' => $request->appraisal_note_1,
            'report_no' => $request->report_no,
        ]);
        return redirect(route('acr.others.index'))->with('success', 'Data Saved Successfully...');
    }


    // todo these function to be shifted in ACR Controller
    public function getUserParameterData($acrId, $paramId)
    {
        return Acr::findOrFail($acrId)->getUserParameterData($paramId);
    }

    public function getUserNegativeParameterData($acrId, $paramId)
    {
      return Acr::findOrFail($acrId)->getUserNegativeParameterData($paramId);
    }


    /**
     *   
     * To View ACR and Accept 
     */
    public function submitReported(Acr $acr)
    {

        return view('employee.other_acr.report_acr', compact('acr'));
    }

    public function storeReportedAcr(Request $request)
    {
        // validate appraisal_officer_type 
        $this->validate(
            $request,
            [
                'acr_id' => 'required|numeric',
                'report_integrity' => 'required',
                'report_remark' => 'nullable',
            ]
        );

        if (($request->report_integrity == '0' || $request->report_integrity  == '-1') && $request->reason == "") {
            return Redirect()->back()->with('fail', 'Remark is Mandatory, for integrity reasons...');
        }

        $acr = Acr::findOrFail($request->acr_id);

        if ($request->report_integrity == '0' || $request->report_integrity  == '-1') {
            $acr->update([
                'report_on' => now(),
                'report_remark' => $request->reason,
                'report_integrity' => $request->report_integrity
            ]);
        } else {
            $acr->update([
                'report_on' => now(),
                'report_integrity' => $request->report_integrity
            ]);
        }

        //    make pdf  and mail notification 

        dispatch(new MakeAcrPdfOnSubmit($acr, 'report'));


        return redirect(route('acr.others.index'))->with('success', 'Acr Saved Successfully...');
    }
}
