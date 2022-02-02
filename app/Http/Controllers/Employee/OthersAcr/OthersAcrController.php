<?php

namespace App\Http\Controllers\Employee\OthersAcr;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acr\StoreAcrRequest;
use App\Models\Acr\Acr;
use App\Models\Acr\AcrProcess;
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
        $reported = Acr::whereNotNull('submitted_at')->whereIn('id', AcrProcess::where('report_employee_id', $this->user->employee_id)
        ->where('is_active', 1)->whereNull('report_on')->get()->pluck('acr_id'))->get();

        $reviewed = Acr::whereNotNull('submitted_at')->whereIn('id', AcrProcess::where('review_employee_id', $this->user->employee_id)
        ->where('is_active', 1)->whereNotNull('report_on')->whereNull('review_on')->get()->pluck('acr_id'))->get();
        
        $accepted = Acr::whereNotNull('submitted_at')->whereIn('id', AcrProcess::where('accept_employee_id', $this->user->employee_id)
        ->where('is_active', 1)->whereNotNull('report_on')->whereNotNull('review_on')->whereNull('accept_on')->get()->pluck('acr_id'))->get();

        return view('employee.other_acr.index', compact('reported','reviewed','accepted'));
    }

    /**
     * @param $id
     * $id => Instance Id
     * To create Estimate
     */
    public function create()
    {  
        $employee = Employee::findOrFail($this->user->employee_id);
        $Officetypes = $this->defineOfficeTypes();
        $acrGroups = $this->defineAcrGroup();
        return view('employee.acr.create', compact('employee','Officetypes','acrGroups'));
    }

    /**
     * @param $request 
     * To Store Indivitual ACR
     */
    public function store(StoreAcrRequest $request)
    { 
        $hrGrievance = Acr::create($request->validated()); 
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



}
