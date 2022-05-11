<?php

namespace App\Http\Controllers\Employee\OthersHrGrievance;

use App\Http\Controllers\Controller;
use App\Models\OfficeJobDefault;
use App\Models\HrGrievance\HrGrievance;
use App\Models\HrGrievance\HrGrievanceType;
use App\Models\Office;
use App\Models\User;
use App\Traits\OfficeTypeTrait;
use Carbon\Carbon;
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

    // view all created grievance for your draft resolvance creating power permissiable Office
    public function index()
    {

        $OfficesAllowedL2 = $this->user->OfficeToAnyJob(['hr-gr-level-2']); // hr-gr-level-2 for Draft Answer
        $grievancesL2 = HrGrievance::whereIn("office_id", $OfficesAllowedL2)->whereIn('status_id', [1, 4, 5])
            ->whereNull('final_answer')->get();

        $OfficesAllowedL1  = $this->user->OfficeToAnyJob(['hr-gr-level-1']); // hr-gr-level-1 for Final Answer
        $grievancesL1 = HrGrievance::whereIn("office_id", $OfficesAllowedL1)->whereIn('status_id', [1, 2, 4, 5])->get();

        $employee_name = $this->user->name;

        return view('employee.others_hr_grievance.index', compact('employee_name', 'grievancesL1', 'grievancesL2'));
    }


    public function resolveGrievance(HrGrievance $hr_grievance)
    {
        if ($this->user->canDoJobInOffice('hr-gr-level-1', $hr_grievance->office_id)) {
            return redirect(route("hr_grievance.resolve.final", ['hr_grievance' => $hr_grievance->id]));
        }

        if ($this->user->canDoJobInOffice('hr-gr-level-2', $hr_grievance->office_id)) {
            return redirect(route('hr_grievance.resolve.addDraft', ['hr_grievance' => $hr_grievance->id]));
        }

        abort_if(
            !$this->user->canDoJobInOffice(['hr-gr-level-1', 'hr-gr-level-2'], $hr_grievance->office_id),
            403, 'You are Not Allowed to view this Office Employees'
        );
    }


    /**    Display the specified Grievance.  */
    public function show(HrGrievance $hr_grievance)
    {
        return view('employee.others_hr_grievance.viewGrievance', compact('hr_grievance'));
    }

    // view all created grievance for your Office
    public function addDraft(HrGrievance $hr_grievance)  // view Add draft   
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

        // $hrGrievance->grievanceAssignedToOfficers('hr-gr-level-1')
        // todo :: mail to L2 => Final Level Officer only

        return view('employee.others_hr_grievance.addDraft', compact('hr_grievance'));
    }

    public function updateGrievance(Request $request)  // Update draft Answer  
    {
        $hrGrievance = HrGrievance::findorFail($request->hr_grievance_id);

        $request->draft_answer = $this->user->shriName . '(' . $this->user->employee->designation->name . ') : \n '   . $request->draft_answer;

        $hrGrievance->update([
            'draft_answer' => $request->draft_answer,
            'status_id' => 2
        ]);

        return Redirect::route('resolve_hr_grievance')->with('success', 'Application Draft Saved Successfully');
    }


    /* View Adding Final Resolving  Answer  */
    public function addFinalAnswer(HrGrievance $hr_grievance)
    {


        return view('employee.others_hr_grievance.addFinalAnswer', compact('hr_grievance'));
    }


    /* Store Final Resolving  Answer    */
    public function resolveFinalGrievance(Request $request)
    {
        $hrGrievance = HrGrievance::findorFail($request->hr_grievance_id);
        $hrGrievance->update($request->all());

 
        // todo :: mail to creater, L1 & L2

        return Redirect::route('resolve_hr_grievance')->with('success', 'Application Draft Saved Successfully');
    }



    public function revertGrievance(Request $request)
    {
        $hrGrievance = HrGrievance::findOrFail($request->grievance_id);
        $hrGrievance->update(['status_id' => 4]);

         
        // todo :: mail to L1 => Draft Level Officer only

        return Redirect::route('resolve_hr_grievance')->with('danger', 'Application Reverted Successfully');
    }


    public function officeHrGrievances(Request $request)
    {
        $offices =  Office::select('id', 'name');

        if ($request->has('start') && $request->has('end')) {
            $this->validate(
                $request,
                [
                    'start' => 'required|date',
                    'end'   => 'required|date',
                ]
            );
            $startDate = $request->start;
            $endDate = $request->end;
        } else {
            $endDate = Carbon::today()->toDateString();
            $startDate = Carbon::today()->subMonths(12)->toDateString();
        }


        $officeId = ($request->has('office_id')) ? $request->office_id : 0;
        $grievanceTypes = HrGrievanceType::all();

        $grievances = HrGrievance::get();



        return view('employee.others_hr_grievance.office_grievance', compact(
            'grievances',
            'offices',
            'officeId',
            'grievanceTypes',
            'startDate',
            'endDate'
        ));
    }
}

/*$usersOffices = $this->user->OfficeToAnyJob(['hr-gr-level-2','hr-gr-level-1']); // hr-gr-level-2 is for Draft and 1 for Final
        $grievances = HrGrievance::whereIn("office_id", $usersOffices)->where('status_id', '>', 0)->get();  // 
       
        return $grievances=$grievances->map(function($grItem) { 
            if($this->user->canDoJobInOffice('hr-gr-level-2',$grItem->office_id)){
                if(in_array($grItem->status_id, [1,4])){
                    $grItem->editable=1;  $grItem->view=1;
                }
            }
            if($this->user->canDoJobInOffice('hr-gr-level-1',$grItem->office_id)){
                if(in_array($grItem->status_id, [1,2])){
                    $grItem->editable=1;  $grItem->view=1;
                }
            } 
            return $grItem;
        });
        $grievances=$grievances->where('editable',1);
       
        $employee_name = $this->user->name;      

        return view('employee.others_hr_grievance.index', compact('employee_name', 'grievances'));*/
