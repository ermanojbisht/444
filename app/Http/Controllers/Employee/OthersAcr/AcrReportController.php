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
           // $acr_master_parameter = $acr->acrMasterParameters()->get();
           $requiredParameters = $acr->type1RequiremntsWithFilledData()->all();
           //   return $acr->reporting_remark;
            return view('employee.acr.form.ifms_ministerial.report_create', compact('acr','filled_data','requiredParameters'));
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
        switch ($this->user->employee_id) {
           case $acr->report_employee_id:
               if ( $acr->report_no > 0 || !$acr->isAcrDuetoLoggedUserfor('report') ){
                    $acrnotProcessable=  false;
                }else{
                    $acrnotProcessable=  true;
                } 
               break;
            case $acr->review_employee_id:
                if ( $acr->review_no > 0 || !$acr->isAcrDuetoLoggedUserfor('review') ){
                    $acrnotProcessable=  false;
                }else{
                    $acrnotProcessable=  true;
                } 
               break;               
           case $acr->accept_employee_id:               
                $acrnotProcessable=  false;              
                break;
        } 
        
        //CHECK whether ACR is processed or is not due 
        abort_if($acrnotProcessable,403,'Dear user ACR is due to process but you have not processed yet.');
        return view('employee.other_acr.report_acr', compact('acr'));
    }

    public function storeReportedAcr(Request $request)
    {
        // validate report_integrity form
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
        //IDENTIFY Process
        switch ($this->user->employee_id) {
           case $acr->report_employee_id:
               return $this->reportProcess($acr,$request);   
               break;
            case $acr->review_employee_id:
                return $this->reviewProcess($request);   
               break;               
           case $acr->accept_employee_id:
               return $this->acceptProcess($request);  
               break;
        } 
        
    }

    public function reportProcess($acr,$request)
    {
        $milestone ='report';
        $this->storeInegerity($acr,$process='report_on',$request);
       

        //check Reviewing is retired
        if($acr->isReviewingRetired()){
            if($acr->isTwoStep){
                //marks of review and accept as per report
                $acr->update(['review_no' => $acr->report_no,'accept_no' => $acr->report_no,'review_on' => now(),'accept_on' => now() ]); 
                $milestone ='accept';
                $acr->updateFinalNo();
            }else{
                //marks of review  as per report
                $acr->update(['review_no' => $acr->report_no,'review_on' => now()]); 
                $milestone ='review';               
            }            
        }else{ 
            //  make pdf  and mail notification            
            dispatch(new MakeAcrPdfOnSubmit($acr, $milestone));
            return redirect(route('acr.others.index'))->with('success', 'Acr Saved Successfully...');//only reported
        }

        //check Accepting is applicable and retired
        if(!$acr->isTwoStep){
            if($acr->isAcceptingRetired()){
                $acr->update(['accept_no' => $acr->report_no,'accept_on' => now()]); 
                $milestone ='accept';
                $acr->updateFinalNo();
            }
        }        
        //  make pdf  and mail notification  
        dispatch(new MakeAcrPdfOnSubmit($acr, $milestone));

        return redirect(route('acr.others.index'))->with('success', 'Acr Saved Successfully...');//reported reviewd accepted
    }

    public function reviewProcess(Request $request)
    {
        $acr=Acr::find($request->acr_id);
        $milestone ='review';
        $acr_is_due = $acr->isAcrDuetoLoggedUserfor('review');
        if ($acr->review_no > 0 || !$acr_is_due) {
        
        }else{
            return redirect(route('acr.others.index'))->with('fail', 'Please process the ACR...');
        }
        if($request->report_integrity){
            $this->storeInegerity($acr,$process='review_on',$request);
        }
        $acr->update(['review_on' => now()]); 

        if ($acr->isTwoStep || $acr->isAcceptingRetired()) {
            $acr->accept_on = now();
            $acr->accept_no = $acr->review_no;
            $acr->save();
            //final no ki entry karo
            $acr->updateFinalNo();
            $milestone ='accept';
        }
        //    make pdf  and mail notification
        dispatch(new MakeAcrPdfOnSubmit($acr, $milestone));

        return redirect(route('acr.others.index'))->with('success', 'Acr Saved Successfully...');
    }

    public function acceptProcess($request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        $this->storeInegerity($acr,$process='accept_onnnn',$request);
        return redirect(route('acr.others.accept.submit', ['acr' => $acr->id]))->with('success', 'Integrity Saved Successfully...');
    }

    public function storeInegerity($acr,$process,$request)
    {
        $acr->update([
            $process => now(),            
            'report_integrity' => $request->report_integrity,
            'integrity_by' => $this->user->employee_id
        ]);
        if ($request->report_integrity == '0' || $request->report_integrity  == '-1') {
            $acr->update(['report_remark' => $request->reason  ]);
        }
    }
}
