<?php

namespace App\Http\Controllers\Employee\OthersAcr;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acr\AcceptedAcrRequest;
use App\Jobs\Acr\MakeAcrPdfOnSubmit;
use Illuminate\Support\Facades\Auth;
use App\Models\Acr\Acr;
/*use Illuminate\Support\Facades\Request;*/
use Illuminate\Http\Request;

class AcrAcceptController extends Controller
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
     *   
     * To View ACR and Accept 
     */
    public function submitAccepted(Acr $acr)
    {
        $acr_is_due = $acr->isAcrDuetoLoggedUserfor('accept');
        return view('employee.other_acr.accept_acr', compact('acr','acr_is_due'));
    }

/*    public function storeAcceptedAcr(AcceptedAcrRequest $request)*/
    public function storeAcceptedAcr(Request $request)
    {
        //return $request->all();
        $acr = Acr::findOrFail($request->acr_id);
        $acr_is_due = $acr->isAcrDuetoLoggedUserfor('accept');


        if ($acr->review_no > 0 ) {
            $this->validate(
                $request,
                [
                    'acr_id'   => 'required',
                    'acr_agree' => 'required|numeric',
                    'reason' => 'required_without_all:acr_agree',
                    'marks' => 'required|numeric|min:1|max:100',
                ]
            );

            if ($request->acr_agree == 0) {
                $acr->update([
                    'accept_no' => $request->marks,
                    'accept_on' => now(),
                    'accept_remark' => $request->reason
                ]);
            } else {
                $acr->update([
                    'accept_no' => $request->marks,
                    'accept_on' => now()
                ]);
            }
        }elseif(!$acr_is_due){
                $acr->update([
                    'accept_on' => now()
                ]);
        }else{
            return redirect()->back()->with('fail', 'Please process the ACR');
        }

        

        //    make pdf  and mail notification
        dispatch(new MakeAcrPdfOnSubmit($acr, 'accept'));


        return redirect(route('acr.others.index'))->with('success', 'Acr Saved Successfully...');
    }
}
