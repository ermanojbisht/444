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
        if($acr->isSinglePage){
            return view('employee.acr.form.single_page.report_create', compact('acr'));
        }

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
        $AcrMasterParameter =  AcrMasterParameter::where('id', $paramId)->first();

        $AcrParameter =  AcrParameter::where('acr_master_parameter_id', $paramId)->where('acr_id', $acrId)->first();

        $text = [];
        $text[] = "<p class='fw-semibold bg-warning p-1'>" . $AcrMasterParameter->description . "</p>";
        if (isset($AcrParameter)) {
            if ($AcrParameter->is_applicable == 1) {
                if ($AcrMasterParameter->config_group == 1001) {
                    $text[] = "<p class='fw-semibold'>";
                    if(empty($AcrParameter->user_achivement)){
                        $text[] = "<span class='text-danger'> not filled </span>";
                    }else{
                        $text[] = "<span class='text-success'>".$AcrParameter->user_achivement." ".$AcrMasterParameter->unit."</span>";
                    }
                    $text[] = "</span> Achivement Against Target <span class='text-danger'>";
                    if(empty($AcrParameter->user_target)){
                        $text[] = "<span class='text-danger'> not filled </span>";
                    }else{
                        $text[] = "<span class='text-success'>".$AcrParameter->user_target." ".$AcrMasterParameter->unit."</span>";
                    }
                    $text[] = "</p>";
                } elseif ($AcrMasterParameter->config_group == 1002) {
                    $text[] = "<p class='fw-semibold text-success'> status : "
                             . $AcrParameter->status 
                             . "</p>";
                } else {
                    $text[] = "<p class='fw-semibold text-danger'> ....... </p>";
                }
            } elseif ($AcrParameter->is_applicable == 0) {
                $text[] = "<p class='fw-semibold text-danger'> User Selected Not Applicable for This Parameter</p>";
            } else {
                $text[] = "<p class='fw-semibold text-danger'> ....... </p>";
            }
        } else {
            $text[] = "<p class='fw-semibold text-danger'> User not Filled any Data</p>";
        }

        return $text;
    }

    public function getUserNegativeParameterData($acrId, $paramId)
    {
       $text ='';

        $AcrMasterParameter =  AcrMasterParameter::where('id', $paramId)->first();

        $groupId = $AcrMasterParameter->config_group;

        $AcrParameter =  AcrNegativeParameter::where('acr_master_parameter_id', $paramId)->where('acr_id', $acrId)->get();
        $text = $text."<p class='fw-semibold bg-warning p-1'>" . $AcrMasterParameter->description . "</p>";
       
        if (isset($AcrParameter)) {
            if ($groupId > 2000 && $groupId < 3000) {
                $text = $text.'<table class="table table-sm table-bordered"><thead><tr>';
                foreach (config('acr.group')[$groupId]['columns'] as $key => $columns) {
                    $text = $text.'<th class="text-info align-middle text-center small">' . $columns['text'] . '</th>';
                }
                $text = $text.'</tr></thead><tbody>';
                $n = 0;
                foreach ($AcrParameter as $Parameter) {
                    $text = $text.'<tr>';
                    foreach (config('acr.group')[$groupId]['columns'] as $key => $columns) {
                        if ($columns['input_type'] === false) {
                            $n = $n + 1;
                            $text = $text.'<td class="text-center small">'.$n.') </td>';
                        } else {
                            $text = $text.'<td class="text-center small ">' . $Parameter[$columns['input_name']] . '</td>';
                        }
                    }
                    $text = $text."</tr>";
                }
                $text = $text."</tbody></table>";
            } elseif ($groupId > 3000) {
                foreach ($AcrParameter as $Parameter) {
                    foreach (config('acr.group')[$groupId]['columns'] as $key => $columns) {
                        $text = $text
                                ."<p>"
                                .$columns['text']
                                ."-- <span class='text-info'>"
                                .$Parameter[$columns['input_name']]
                                ."</span></p>";
                    }
                }
            }
        } else {
            $text = $text."<p class='fw-semibold text-danger'> User not Filled any Data</p>";
        }
        return $text;
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
                'integrity' => 'required',
                'report_remark' => 'nullable',
            ]
        );

        if ($request->integrity == 'false' && $request->reason == "") {
            return Redirect()->back()->with('fail', 'Remark is Mandatory, for integrity reasons...');
        }

        $acr = Acr::findOrFail($request->acr_id);

        if ($request->integrity == 'false') {
            $acr->update([
                'report_on' => now(),
                'report_remark' => $request->reason
            ]);
        } else {
            $acr->update([
                'report_on' => now() 
            ]);
        }

        //    make pdf  and mail notification 

        dispatch(new MakeAcrPdfOnSubmit($acr, 'report'));


        return redirect(route('acr.others.index'))->with('success', 'Acr Saved Successfully...');
    }
}
