<?php

namespace App\Http\Controllers\Employee\OthersAcr;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acr\StoreAcrRequest;
use App\Jobs\Acr\MakeAcrPdfOnSubmit;
use App\Models\Acr\Acr;
use App\Models\Acr\AcrRejection;
use App\Models\Employee;
use App\Models\Office;
use App\Traits\AcrFormTrait;
use App\Traits\OfficeTypeTrait;
use Carbon\Carbon;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

class AcrInboxController extends Controller
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
     * To View All ACR Created marked for logged in Employee
     * as => Reporting, Reviewing or Accepting
     */
    public function index()
    {
        /*$reported = Acr::whereNotNull('submitted_at')->where('report_employee_id', $this->user->employee_id)
            ->where('is_active', 1)->whereNull('report_on')->get();*/
        $reported =$this->user->pendingAcrsToProcess('report');
        $reported->map(function ($acr) {
            $acr->is_due = $acr->isAcrDuetoLoggedUserfor('report');
            return $acr;
        });



        /*$reviewed = Acr::whereNotNull('submitted_at')->where('review_employee_id', $this->user->employee_id)
            ->where('is_active', 1)->whereNotNull('report_on')->whereNull('review_on')->get();*/
        $reviewed =$this->user->pendingAcrsToProcess('review');
        $reviewed->map(function ($acr) {
            $acr->is_due = $acr->isAcrDuetoLoggedUserfor('review');
            return $acr;
        });

        /*$accepted = Acr::whereNotNull('submitted_at')->where('accept_employee_id', $this->user->employee_id)
            ->where('is_active', 1)->whereNotNull('report_on')->whereNotNull('review_on')->whereNotNull('review_no')
            ->whereNull('accept_on')->get();*/
        $accepted =$this->user->pendingAcrsToProcess('accept');

        $accepted->map(function ($acr) {
            $acr->is_due = $acr->isAcrDuetoLoggedUserfor('accept');
            return $acr;
        });

        return view('employee.other_acr.index', compact('reported', 'reviewed', 'accepted'));
    }

    public function addOfficers(Acr $acr)
    {
        $appraisalOfficers =  $acr->appraisalOfficers()->get();

        return view('employee.acr.add_officers', compact('acr', 'appraisalOfficers'));
    }

    public function addAcrOfficers(Request $request)
    {
        // validate appraisal_officer_type 
        $this->validate(
            $request,
            [
                'appraisal_officer_type' => 'required',
                'from_date' => 'required|date',
                'to_date' => 'required|date',
                'employee_id' => 'required' // in AppraisalOfficer acr_id , appraisal_officer_type, employee_id should not be repeated 
            ]
        );

        $acr = Acr::findOrFail($request->acr_id);
        $appraisal_officer_type = $request->appraisal_officer_type;
        $startDate = Carbon::createFromFormat('Y-m-d', $request->from_date);
        $endDate = Carbon::createFromFormat('Y-m-d', $request->to_date);

        $result = $acr->checkPeriodInput($startDate, $endDate, $appraisal_officer_type); //  give ['status'=>true,'msg'=>'']

        if (!$result['status']) {
            return Redirect()->back()->with('fail', $result['msg']);
        }

        $acr->appraisalOfficers()->attach($request->employee_id, array(
            'appraisal_officer_type' => $appraisal_officer_type,
            'from_date' => $request->from_date, 'to_date' => $request->to_date
        ));

        $acr->updateIsDue($appraisal_officer_type);
        return Redirect()->back()->with('success', 'Officer has been Added to ACR Successfully...');
    }

    public function deleteAcrOfficers(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        if ($acr->isSubmitted()) {
            return Redirect()->back()->with('fail', ' ACR is already Submitted, Thus No Offcials can be deleted...');
        }
        $acr->appraisalOfficers()->wherePivot('appraisal_officer_type', $request->appraisal_officer_type)->detach();
        return Redirect()->back()->with('success', 'Officer deleted Successfully...');
    }


    public function reject(Acr $acr, $dutyType)
    {

        if (in_array($dutyType, ['report', 'review', 'accept'])) {
            $officer = $acr->userOnBasisOfDuty($dutyType);
            return view('employee.acr.reject_acr', compact('acr', 'officer', 'dutyType'));
        }

        return Redirect()->back()->with('fail', 'Cannot reject ACR...');
    }

    public function storeReject(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        AcrRejection::create($request->all());
        $acr->update(['is_active' => 0]);

        dispatch(new MakeAcrPdfOnSubmit($acr, 'reject'));

        return redirect(route('acr.others.index'));
    }



    /**
     * View Employee's Acr after Entering Employee Code from Side bar 
     */
    public function view(Employee $employee)
    {
        $acrs = Acr::where('employee_id', $employee->id)->get();

        return view('employee.acr.employee_acr', compact('acrs', 'employee'));
    }

    public function officeAcrsView(Request $request)
    {
        $officeId = ($request->has('office_id')) ? $request->office_id : 'none';

        if ($request->has('start') && $request->has('end')) {
            $this->validate(
                $request,
                [
                    'start' => 'required|date',
                    'end' => 'required|date'
                ]
            );
            $startDate = $request->start;
            $endDate = $request->end;

        } else {
            $endDate =Carbon::today()->toDateString();
            $startDate = Carbon::today()->subMonths(12)->toDateString();

        }
         $acrs = ACR::periodBetweenDates([$startDate,$endDate])->where('is_active', 1);

        if ($officeId === 'all') {
            $acrs = $acrs->get();
        }

        if ($officeId === 'none') {
            $acrs = false;
        }

        if ($officeId > 0) {
            $acrs = $acrs->where('office_id', $officeId)->get();
        }

        $offices = Office::select('name', 'id')->get();

        return view('employee.acr.office_acrs', compact('acrs', 'officeId', 'offices', 'startDate', 'endDate'));
    }

    /**
     * View Integrity Certificate for PDF 
     */
    public function viewIntegrity(Acr $acr)
    {

        return view('employee.other_acr.view_reported_acr', compact('acr'));
    }

    /**
     * View Acceptance Certificate for PDF 
     */
    public function viewAccepted(Acr $acr)
    {

        return view('employee.other_acr.view_accepted_acr', compact('acr'));
    }
}
