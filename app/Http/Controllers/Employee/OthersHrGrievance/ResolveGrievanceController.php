<?php

namespace App\Http\Controllers\Employee\HrGrivance\Officer;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\OfficeJobDefault;
use App\Models\Track\Grivance\HrGrivance;
use App\Models\Track\Grivance\HrGrivanceType;
use App\Traits\OfficeTypeTrait;
use Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Redirect;



class ResolveGrievanceController extends Controller
{

    use OfficeTypeTrait;

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

    // view all created grivance for your Office
    public function index()
    {
        $canCreateDefaultAnswer = false;
        $canCreateFinalAnswer = false;
        $employee_name = $this->user->name;
        $Office_id  = 0;
        $user_id = $this->user->id;
        $office_job_default = OfficeJobDefault::where("user_id", $user_id)->get();
        if ($office_job_default) {
            $Office_id = $office_job_default[0]->ee_office_id;
            foreach ($office_job_default as $office_job) {
                if ($office_job->job_id == 4)
                    $canCreateDefaultAnswer = true;
                if ($office_job->job_id == 5)
                    $canCreateFinalAnswer = true;
            }
        }
        $grivances =  HrGrivance::where("office_id", $Office_id)->get();

        return view('employee.hr_grivance.Officer.index', compact('employee_name', 'grivances', 'canCreateDefaultAnswer', 'canCreateFinalAnswer'))->with('success', '');
    }


    /**
     * Display the specified Grivance.
     *
     * @param  \App\Models\Track\Grivance\HrGrivance
     * @return \Illuminate\Http\Response
     */
    public function show(HrGrivance $hr_grivance)
    {
        return view('employee.hr_grivance.officer.viewGrivance', compact('hr_grivance'));
    }

    // view all created grivance for your Office
    public function addDraft(HrGrivance $hr_grivance)
    {
        $canCreateDefaultAnswer = false;
        $canCreateFinalAnswer = false;
        $employee_name = $this->user->name;
        $Office_id  = 0;
        $user_id = $this->user->id;
        $office_job_default = OfficeJobDefault::where("user_id", $user_id)->get();
        if ($office_job_default) {
            $Office_id = $office_job_default[0]->ee_office_id;  // can work for All EE, SE and CE Offices ?? TODO :: ask the issue.  
            foreach ($office_job_default as $office_job) {
                if ($office_job->job_id == 4)
                    $canCreateDefaultAnswer = true;
                if ($office_job->job_id == 5)
                    $canCreateFinalAnswer = true;
            }
        }
        $grivances =  HrGrivance::where("office_id", $Office_id)->get();
        return view('employee.hr_grivance.officer.addDraft', compact('hr_grivance'));
    }

          /**
     * Display the specified Grivance.
     *
     * @param  \App\Models\Track\Grivance\HrGrivance
     * @return \Illuminate\Http\Response
     */
    public function addFinalAnswer(HrGrivance $hr_grivance)
    {
        return view('employee.hr_grivance.officer.addFinalAnswer', compact('hr_grivance'));
    }



    public function updateGrievance(Request $request)
    {
        // Ur data has been updated successfuly   
        $hrGrivance = HrGrivance::findorFail($request->hr_grivance_id);
        $hrGrivance->update($request->all());

        return Redirect::route('office_hr_grivance')->with('success', 'Application Resolved Successfully');
    }

 
  
}
