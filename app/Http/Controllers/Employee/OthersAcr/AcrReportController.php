<?php

namespace App\Http\Controllers\Employee\OthersAcr;

use App\Http\Controllers\Controller;
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
        $requiredParameters = $acr->type1RequiremntsWithFilledData()->first();
        $requiredNegativeParameters = $acr->type2RequiremntsWithFilledData();
        $personal_attributes=  $acr->peronalAttributeSWithMasterData();

        $view = false; // make true for view only
        return view('employee.acr.form.appraisal',compact('acr','requiredParameters','personal_attributes','requiredNegativeParameters','view')); //'notApplicableParameters',
    }


    public function storeAppraisal1(Request $request)
    {
        //return $request->all(); 
        
        $acr = Acr::findOrFail($request->acr_id);
        $acr->update([
            'appraisal_note_1' => $request->appraisal_note_1,
            'appraisal_note_2' => $request->appraisal_note_2,
            'appraisal_note_3' => $request->appraisal_note_3,
            'report_no'=> $request->final_marks,
        ]);

        foreach($request->reporting_marks as $parameterId => $reporting_mark ){
            AcrParameter::UpdateOrCreate(
                [
                    'acr_id' => $request->acr_id,
                    'acr_master_parameter_id' => $parameterId,
                ],
                [
                    'reporting_marks' => $reporting_mark,
                ]
            );
        }
        foreach($request->personal_attributes as $attributeId => $attribute_mark ){
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
        return redirect()->back();
    }

    // todo these function to be shifted in ACR Controller
    public function getUserParameterData($acrId, $paramId)
    {   
        $AcrMasterParameter =  AcrMasterParameter::where('id',$paramId)->first();
       
        $AcrParameter =  AcrParameter::where('acr_master_parameter_id',$paramId)->where('acr_id',$acrId)->first();

        $text = [];
        $text[] = "<p class='fs-5 fw-semibold my-0'>User Input For </p>";
        $text[] = "<p class='text-info fs-5 fw-bold'>" . $AcrMasterParameter->description . "</p>";
        if (isset($AcrParameter)) {
            if ($AcrParameter->is_applicable == 1) {
                if ($AcrMasterParameter->config_group == 1001) {
                    $text[] = "<p class='fs-5 fw-semibold'> Target : " . ($AcrParameter->user_target ?? '') . " " . $AcrMasterParameter->unit . "</p>";
                    $text[] = "<p class='fs-5 fw-semibold'> Achivement : " . ($AcrParameter->user_achivement ?? '') . " " . $AcrMasterParameter->unit . "</p>";
                } elseif ($AcrMasterParameter->config_group == 1002) {
                    $text[] = "<p class='fs-5 fw-semibold'> status : " . $AcrParameter->status . "</p>";
                } else {
                }
            } elseif ($AcrParameter->is_applicable == 0) {
                $text[] = "<p class='fs-5 fw-semibold text-danger'> User Declare it as Not Applicable</p>";
            } else {
            }
        } else {
            $text[] = "<p class='fs-5 fw-semibold text-danger'> User not Filled any Data</p>";
        }

        return $text;
    }

    public function getUserNegativeParameterData($acrId, $paramId)
    {
        $text = [];

        $AcrMasterParameter =  AcrMasterParameter::where('id', $paramId)->first();

        $groupId = $AcrMasterParameter->config_group;

        $AcrParameter =  AcrNegativeParameter::where('acr_master_parameter_id', $paramId)->where('acr_id', $acrId)->get();

        $text[] = "<p class='fs-5 fw-semibold my-0'>User Input For </p>";
        $text[] = "<p class='text-info fs-5 fw-bold'>" . $AcrMasterParameter->description . "</p>";

        if (isset($AcrParameter)) {
            if ($groupId > 2000 && $groupId < 3000) {
                $text[] = '<table>';
                $text[] = '<thead>';
                $text[] = '<tr>';
                foreach (config('acr.group')[$groupId]['columns'] as $key => $columns) {
                    $text[] = '<th>' . $columns['text'] . '</th>';
                }
                $text[] = '</tr>';
                $text[] = '</thead>';
                $text[] = '<tbody>';
                foreach ($AcrParameter as $Parameter) {
                    $text[] = '<tr>';
                    foreach (config('acr.group')[$groupId]['columns'] as $key => $columns) {
                        if ($columns['input_type'] === false) {
                            $text[] = '<td>Sl no</td>';
                        } else {
                            $text[] = '<td>' . $Parameter[$columns['input_name']] . '</td>';
                        }
                    }
                    $text[] = "</tr>";
                }
                $text[] = "</tbody>";
                $text[] = "</table>";
            } elseif ($groupId > 3000) {
                $text[] = "<p class='fs-5 fw-semibold text-danger'>to be develop</p>";
            }
        } else {
            $text[] = "<p class='fs-5 fw-semibold text-danger'> User not Filled any Data</p>";
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

    public function saveReportedAcr(Request $request)
    {

        // validate appraisal_officer_type 
        $this->validate(
            $request,
            [
                'acr_id' => 'required|numeric',
                'integrity' => 'required',
            ]
        );

        if ($request->integrity == 'false' && $request->remark == "") {
            return Redirect()->back()->with('fail', 'Remark is Mandatory, for integrity reasons...');
        }
        $acr = Acr::findOrFail($request->acr_id);

        $acr->update([
            'report_on' => now(),
            'report_remark' => $request->remark
        ]);

        return redirect(route('acr.others.index'))->with('success', 'Acr Saved Successfully...');
    }
}