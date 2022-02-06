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
use App\Models\Acr\AcrPersonalAttributes;

use App\Models\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  
use Log;

class AcrReviewController extends Controller
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
    public function appraisal2(Acr $acr, Request $request)
    {
        $requiredParameters = $acr->type1RequiremntsWithFilledData()->first();
        $requiredNegativeParameters = $acr->type2RequiremntsWithFilledData();

        $AcrPersonalAttributes = AcrPersonalAttributes::where('acr_id',$acr->id)->get()->keyBy('personal_attribute_id');
        $personal_attributes=  AcrMasterPersonalAttributes::all()->map(function ($row) use ($AcrPersonalAttributes) {
            if (isset($AcrPersonalAttributes[$row->id])) {
                $row->reporting_marks = $AcrPersonalAttributes[$row->id]->reporting_marks;
                $row->reviewing_marks = $AcrPersonalAttributes[$row->id]->reviewing_marks;
            } else {
                $row->reporting_marks = $row->reviewing_marks = '';
            }
            return $row;
        });

        $view = true; // make true for view only
        return view('employee.acr.form.appraisal2',compact('acr','requiredParameters','personal_attributes','requiredNegativeParameters','view')); //'notApplicableParameters',
    }


    public function storeAppraisal2(Request $request)
    {
        //return $request->all(); 
        
        $acr = Acr::findOrFail($request->acr_id);

        foreach($request->reviewing_marks as $parameterId => $reviewing_mark ){
            AcrParameter::UpdateOrCreate(
                [
                    'acr_id' => $request->acr_id,
                    'acr_master_parameter_id' => $parameterId,
                ],
                [
                    'reviewing_marks' => $reviewing_mark,
                ]
            );
        }
        foreach($request->personal_attributes as $attributeId => $attribute_mark ){
            AcrPersonalAttributes::UpdateOrCreate(
                [
                    'acr_id' => $request->acr_id,
                    'personal_attribute_id' => $attributeId,
                ],
                [
                    'reviewing_marks' => $attribute_mark,
                ]
            );
        }
        return redirect()->back();
    }

}
