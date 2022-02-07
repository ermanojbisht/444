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

    public function saveAcceptedAcr(AcceptedAcrRequest $request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        $acr->update([
            'accept_no' => $request->acr_group_id,
            'accept_on' => now()
        ]);

        return redirect(route('acr.others.index'))->with('success', 'Acr Saved Successfully...');
    }


    
}