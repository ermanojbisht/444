<?php

namespace App\Http\Controllers\Employee\OthersHrGrievance;

use App\Http\Controllers\Controller;
use App\Models\OfficeJobDefault;
use App\Models\HrGrievance\HrGrievance;
use App\Models\HrGrievance\HrGrievanceType;
use App\Models\User;
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


    // $user = User::whereEmployeeId('010096816')->first();
    // return  $user->OfficeToAnyJob(['hr-gr-level-2', 'hr-gr-level-1']);
    // view all created grievance for your draft resolvance creating power permissiable Office
    public function index()
    {
        $usersOffices = $this->user->OfficeToAnyJob(['hr-gr-level-2', 'hr-gr-level-1']); //
        $grievances =  HrGrievance::whereIn("office_id", $usersOffices)->whereNull('final_answer')->get();
        $employee_name = $this->user->name;

        return view('employee.others_hr_grievance.index', compact('employee_name', 'grievances'));
    }


    public function resolveGrievance(HrGrievance $hr_grievance)
    {
        if ($hr_grievance->draft_answer) {  // draft has been given 

            if ($this->user->canDoJobInOffice('hr-gr-level-1', $hr_grievance->office_id)) {
                return redirect(route("hr_grievance.resolve.final", ['hr_grievance' => $hr_grievance->id]));
            }

            if ($this->user->canDoJobInOffice('hr-gr-level-2', $hr_grievance->office_id)) {
                return redirect(route('hr_grievance.resolve.addDraft', ['hr_grievance' => $hr_grievance->id]));
            }

            abort_if(!$this->user->canDoJobInOffice('hr-gr-level-1', $hr_grievance->office_id), 403, 'You are Not Allowed to view this Office Employees');
            abort_if(!$this->user->canDoJobInOffice('hr-gr-level-2', $hr_grievance->office_id), 403, 'You are Not Allowed to view this Office Employees');
        } else {


            abort_if(!$this->user->canDoJobInOffice('hr-gr-level-2', $hr_grievance->office_id), 403, 'You are Not Allowed to view this Office Employees');
            return redirect(route('hr_grievance.resolve.addDraft', ['hr_grievance' => $hr_grievance->id]));
        }
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

    public function updateGrievance(Request $request)
    {
        $hrGrievance = HrGrievance::findorFail($request->hr_grievance_id);
        $hrGrievance->update($request->all());

        return Redirect::route('resolve_hr_grievance')->with('success', 'Application Draft Saved Successfully');
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

    public function resolveFinalGrievance(Request $request)
    {
        $hrGrievance = HrGrievance::findorFail($request->hr_grievance_id);
        $hrGrievance->update($request->all());

        return Redirect::route('resolve_hr_grievance')->with('success', 'Application Draft Saved Successfully');
    }
}
