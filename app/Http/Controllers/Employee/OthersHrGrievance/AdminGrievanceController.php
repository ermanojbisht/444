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



class AdminGrievanceController extends Controller
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

         

        return view('employee.others_hr_grievance.index', compact('employee_name', 'grievancesL1', 'grievancesL2'));
    }

  

    // view all created grievance for your Office
    public function addDraft(HrGrievance $hr_grievance)  // view Add draft   
    {
        

        return view('employee.others_hr_grievance.addDraft', compact('hr_grievance'));
    }


    /* Store Final Resolving  Answer    */
    public function resolveFinalGrievance(Request $request)
    {
        $hrGrievance = HrGrievance::findorFail($request->hr_grievance_id);
        $hrGrievance->update($request->all());
        $hrGrievance->notificationFor('final');

        return Redirect::route('resolve_hr_grievance')->with('success', 'Application Draft Saved Successfully');
    }



      
}
 