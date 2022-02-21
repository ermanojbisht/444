<?php

namespace App\Http\Controllers\Employee\OthersAcr;

use App\Http\Controllers\Controller;
use App\Jobs\Acr\MakeAcrPdfOnSubmit;
use App\Models\Acr\Acr;
use App\Models\Acr\AcrParameter;
use App\Models\Acr\AcrPersonalAttribute;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcrReviewController extends Controller {

    /**
     * @var mixed
     */
    protected $user;

    /**
     * @return mixed
     */
    public function __construct() {
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
    public function appraisal2(Acr $acr, Request $request) {

        if($acr->isSinglePage){
            return view('employee.acr.form.single_page.review_create', compact('acr'));
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
        $personal_attributes = $acr->peronalAttributeSWithMasterData();

       
        return view('employee.acr.form.appraisal2', compact('acr', 'requiredParameters', 'personal_attributes', 'requiredNegativeParameters', 'applicableParameters','exceptional_reporting_marks','exceptional_reviewing_marks')); 
    }

    public function storeAppraisal2(Request $request) {
        //return $request->all();
        $this->validate($request,
            [
                'marks_positive' => 'array',
                'marks_positive.*' => 'numeric | nullable',
                'positive_factor' => 'numeric',
                'marks_negative' => 'array',
                'marks_negative.*' => 'numeric | nullable',
                'personal_attributes' => 'array',
                'personal_attributes.*' => 'numeric | nullable',
            ]
        );

        $review_no = 0;

        $acr = Acr::findOrFail($request->acr_id);

        if($request->positive_factor > 0){ // if altlest a parameter applicable 
            foreach ($request->marks_positive as $parameterId => $reviewing_mark) {
                $review_no = $review_no + $reviewing_mark * $request->positive_factor;
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
        }else{ // if no parameter applicable
            $first = AcrParameter::where('acr_id',$request->acr_id)->first();
            $first->Update(
                ['reviewing_marks' => $request->exceptional_reviewing_marks]
            );
            $review_no = $request->exceptional_reviewing_marks;
        }

        foreach ($request->personal_attributes as $attributeId => $attribute_mark) {
            $review_no = $review_no + $attribute_mark * 1;
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

        foreach ($request->marks_negative as $parameterId => $reviewing_mark) {
            $review_no = $review_no - $reviewing_mark * 1;
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

        $acr->update([
            'review_no' => $review_no,
        ]);

        return redirect()->back();
    }
    /**
     * [storeAcrWithoutProcessReview in case if acr has no target / negative/ personnal attribiute
     * in single page acr
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function storeAcrWithoutProcessReview(Request $request) {
        $acr = Acr::findOrFail($request->acr_id);
        $acr->update([
            'review_remark' => $request->review_remark,
            'review_no' => $request->review_no,
        ]);
        // return $request->all();
        return redirect(route('acr.others.index'))->with('success', 'Data Saved Successfully...');
    }

    public function storeReviewedAcr(Request $request) {
        $acr = Acr::findOrFail($request->acr_id);

        if ($acr->review_no <= 0) {
            return redirect()->back()->with('fail', 'Please process the ACR');
        }

        $acr->update(['review_on' => now()]);

        if ($acr->isTwoStep) {
            $acr->accept_on = now();
            $acr->accept_no = $acr->review_no;
            $acr->save();
        }

        //    make pdf  and mail notification
        dispatch(new MakeAcrPdfOnSubmit($acr, 'review'));

        return redirect(route('acr.others.index'))->with('success', 'Acr Saved Successfully...');
    }
}
