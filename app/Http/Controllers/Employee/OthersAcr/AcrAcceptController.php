<?php

namespace App\Http\Controllers\Employee\OthersAcr;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acr\AcceptedAcrRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Acr\Acr;
use Illuminate\Support\Facades\Request;

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
       
        return view('employee.other_acr.accept_acr', compact('acr'));
    }

    public function storeAcceptedAcr(AcceptedAcrRequest $request)
    {
        $acr = Acr::findOrFail($request->acr_id);

        if ($request->marks <= 0) {
            return redirect()->back()->with('fail', 'Please process the ACR');
        }

        $acr->update([
            'accept_no' => $request->marks,
            'accept_on' => now(),
            'accept_remark' => $request->reason
        ]);

        return redirect(route('acr.others.index'))->with('success', 'Acr Saved Successfully...');
    }
}
