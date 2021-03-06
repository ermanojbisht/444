<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Log;
use Auth;

class HomeController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            //abort_if(Gate::denies('track_estimate'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $this->user = Auth::User();
            return $next($request);
        });
    }
    /**
     * redirect admin after login
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        if(!$this->user->fromShashan()){
            $fromShashan = false;
            $user_grievance_count=$this->user->grievances()->count();
            $user_grievance_received_count=$this->user->grievances()->count();
            
            $user_acr_count=$this->user->employee->activeAcrs()->count();
            $user_acr_to_report_count=$this->user->pendingAcrsToProcess('report')->count();
            $user_acr_to_review_count=$this->user->pendingAcrsToProcess('review')->count();
            $user_acr_to_accept_count=$this->user->pendingAcrsToProcess('accept')->count();
            
            
        }else{
            $fromShashan = true;
             $user_grievance_count=$user_acr_count=$user_acr_to_report_count=$user_acr_to_review_count=$user_acr_to_accept_count=0;
        }
        return view('employee.home',compact('user_grievance_count','user_acr_count','user_acr_to_report_count','user_acr_to_review_count','user_acr_to_accept_count','fromShashan'));
    }

    /**
     * @param Request $request
     */
    public function employeeBasicData(Request $request)
    {
        return Employee::findOrFail($request->employee_id)->detailAsHtml();
    }
}
