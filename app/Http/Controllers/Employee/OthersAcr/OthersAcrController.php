<?php

namespace App\Http\Controllers\Employee\OthersAcr;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acr\StoreAcrRequest;
use App\Models\Acr\Acr;
use App\Models\Acr\AcrRejection;
use App\Models\Employee;
use App\Traits\AcrFormTrait;
use App\Traits\OfficeTypeTrait;
use Carbon\Carbon;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  

class OthersAcrController extends Controller
{

    use OfficeTypeTrait, AcrFormTrait;

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
     * To View All ACR Created by logged in Employee
     */
    public function index()
    {

        $reported = Acr::whereNotNull('submitted_at')->where('report_employee_id', $this->user->employee_id)
        ->where('is_active', 1)->whereNull('report_on')->get();

        $reviewed = Acr::whereNotNull('submitted_at')->where('review_employee_id', $this->user->employee_id)
        ->where('is_active', 1)->whereNotNull('report_on')->whereNull('review_on')->get();
        
        $accepted = Acr::whereNotNull('submitted_at')->where('accept_employee_id', $this->user->employee_id)
        ->where('is_active', 1)->whereNotNull('report_on')->whereNotNull('review_on')->whereNotNull('review_no')
        ->whereNull('accept_on')->get();
        
        return view('employee.other_acr.index', compact('reported','reviewed','accepted'));
    }

    /**
     * @param $request 
     * To Store Indivitual ACR
     */
    public function store(StoreAcrRequest $request)
    { 
        Acr::create($request->validated());

        return redirect(route('acr.myacrs'));
    }


    public function addOfficers(Acr $acr)
    {
        $appraisalOfficers =  $acr->appraisalOfficers()->get();

        return view('employee.acr.add_officers', compact('acr','appraisalOfficers'));
    }

    public function addAcrOfficers (Request $request)
    {
        // validate appraisal_officer_type 
        $this->validate($request,
        [
            'appraisal_officer_type' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date', 
            'employee_id' => 'required' // in AppraisalOfficer acr_id , appraisal_officer_type, employee_id should not be repeated 
        ]);

        $acr = Acr::findOrFail($request->acr_id);
        $appraisal_officer_type = $request->appraisal_officer_type;
        $startDate = Carbon::createFromFormat('Y-m-d', $request->from_date);
        $endDate = Carbon::createFromFormat('Y-m-d', $request->to_date);

        $result = $acr->checkPeriodInput($startDate,$endDate,$appraisal_officer_type); //  give ['status'=>true,'msg'=>'']
        
        if(!$result['status'])
        {
            return Redirect()->back()->with('fail',$result['msg']);
        } 

        $acr->appraisalOfficers()->attach($request->employee_id, array('appraisal_officer_type'=>$appraisal_officer_type,
        'from_date'=>$request->from_date, 'to_date' => $request->to_date));
         
        $acr->updateIsDue($appraisal_officer_type);  
        return Redirect()->back()->with('success', 'Officer has been Added to ACR Successfully...' );
    }

    public function deleteAcrOfficers(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        if($acr->isSubmitted())
        {
            return Redirect()->back()->with('fail', ' ACR is already Submitted, Thus No Offcials can be deleted...' );
        }
        $acr->appraisalOfficers()->wherePivot('appraisal_officer_type', $request->appraisal_officer_type)->detach();
        return Redirect()->back()->with('success', 'Officer deleted Successfully...' );
    }

    public function view(Employee $employee)
    {
        $acrs = Acr::where('employee_id',$employee->id)->get();
        
        return view('employee.acr.employee_acr', compact('acrs','employee'));
    }

    public function viewIntegrity(Acr $acr)
    {
         
        return view('employee.other_acr.view_reported_acr', compact('acr'));
    }

    
    public function viewAccepted(Acr $acr)
    {
        return view('employee.other_acr.view_accepted_acr', compact('acr'));
    }
    
    public function reject(Acr $acr, $officerType)
    {
        if ($officerType == 'report') {
            $officer = $acr->reportUser();
        } else if ($officerType == 'review') {
            $officer = $acr->reviewUser();
        } else if ($officerType == 'accept') {
            $officer = $acr->acceptUser();
        } else {
            return Redirect()->back()->with('fail', 'Cannot reject ACR...');
        }

        return view('employee.acr.reject_acr', compact('acr', 'officer'));
    }

    public function storeReject(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        AcrRejection::create($request->all());
        $acr->update(['is_active' => 0]);

        return redirect(route('acr.others.index')); 
    }


}
