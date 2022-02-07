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
        $personal_attributes =  $acr->peronalAttributeSWithMasterData();

        $view = false; // make true for view only
        return view('employee.acr.form.appraisal2', compact('acr', 'requiredParameters', 'personal_attributes', 'requiredNegativeParameters', 'view')); //'notApplicableParameters',
    }


    public function storeAppraisal2(Request $request)
    {
        //return $request->all(); 

        $acr = Acr::findOrFail($request->acr_id);
        $acr->update([
            'review_no' => $request->final_marks,
        ]);

        foreach ($request->reviewing_marks as $parameterId => $reviewing_mark) {
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
        foreach ($request->personal_attributes as $attributeId => $attribute_mark) {
            AcrPersonalAttribute::UpdateOrCreate(
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


    public function storeReviewedAcr(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        
        if ($acr->review_no <= 0) {
            return redirect()->back()->with('fail', 'Please process the ACR');
        }

        $acr->update([
            'review_on' => now()
        ]);

        //    make pdf  and mail notification 
        dispatch(new MakeAcrPdfOnSubmit($acr, 'review'));

        return redirect(route('acr.others.index'))->with('success', 'Acr Saved Successfully...');
    }
}
