<?php

namespace App\Http\Controllers\Employee\OthersHrGrievance;

use App\Http\Controllers\Controller;
use App\Models\OfficeJobDefault;
use App\Models\HrGrievance\HrGrievance;
use App\Models\HrGrievance\HrGrievanceType;
use App\Traits\OfficeTypeTrait;
use Gate;
use Illuminate\Support\Facades\Auth;
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

    // view all created grievance for your Office
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
        $grievances =  HrGrievance::where("office_id", $Office_id)->get();

        return view('employee.others_hr_grievance.index', compact('employee_name', 'grievances', 'canCreateDefaultAnswer', 'canCreateFinalAnswer'))->with('success', '');
    }


    /**
     * Display the specified Grievance.
     *
     * @param  \App\Models\Track\Grievance\HrGrievance
     * @return \Illuminate\Http\Response
     */
    public function show(HrGrievance $hr_grievance)
    {
        return view('employee.others_hr_grievance.viewGrievance', compact('hr_grievance'));
    }

    // view all created grievance for your Office
    public function addDraft(HrGrievance $hr_grievance)
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
                if ($office_job->job_id == 1)
                    $canCreateDefaultAnswer = true;
                if ($office_job->job_id == 2)
                    $canCreateFinalAnswer = true;
            }
        }
        $grievances =  HrGrievance::where("office_id", $Office_id)->get();
        return view('employee.others_hr_grievance.addDraft', compact('hr_grievance'));
    }

          /**
     * Display the specified Grievance.
     *
     * @param  \App\Models\Track\Grievance\HrGrievance
     * @return \Illuminate\Http\Response
     */
    public function addFinalAnswer(HrGrievance $hr_grievance)
    {
        return view('employee.others_hr_grievance.addFinalAnswer', compact('hr_grievance'));
    }



    public function updateGrievance(Request $request)
    {
        // Ur data has been updated successfuly   
        $hrGrievance = HrGrievance::findorFail($request->hr_grievance_id);
        $hrGrievance->update($request->all());

        return Redirect::route('office_hr_grievance')->with('success', 'Application Resolved Successfully');
    }

 
  
}
