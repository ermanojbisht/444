<?php

namespace App\Http\Controllers\Employee\Acr;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acr\StoreAcrLeaveRequest;
use App\Http\Requests\Acr\StoreAcrRequest;
use App\Jobs\Acr\MakeAcrPdfOnSubmit;
use App\Models\Acr\Acr;
use App\Models\Acr\AcrType;
use App\Models\Acr\Appreciation;
use App\Models\Acr\Leave;
use App\Models\Employee;
use App\Models\Office;
use App\Traits\Acr\AcrFormTrait;
use App\Traits\OfficeTypeTrait;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Log;

class AcrController extends Controller
{

    use OfficeTypeTrait, AcrFormTrait;

    /**
     * @var mixed
     */
    protected $user;
    protected $msg403 = 'Unauthorized action.You are not authorised to see this ACR details';

    /**
     * @return mixed
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            //abort_if(Gate::denies('track_estimate'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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

        if ($this->user->fromShashan()) {
            return redirect()->route('acr.others.index');
        }

        $acrs = Acr::where('employee_id', '=', $this->user->employee_id)->orderBy('id', 'DESC')->get();

        return view('employee.acr.my_acr', compact('acrs'));
    }

    /**
     * @param $id
     * $id => Instance Id
     * To create Acr
     */
    public function create()
    {
        $employee = Employee::findOrFail($this->user->employee_id);
        $Officetypes = $this->defineOfficeTypes();
        $acrGroups = $this->defineAcrGroup();

        return view('employee.acr.create', compact('employee', 'Officetypes', 'acrGroups'));
    }

    /**
     * @param $request 
     * To Store Indivitual ACR
     */
    public function store(StoreAcrRequest $request)
    {
        $start = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
        $end = Carbon::createFromFormat('Y-m-d', $request->to_date)->startOfDay();

        $result =Employee::findOrFail($request->employee_id)->checkAcrDateInBetweenPreviousACRFilled($start, $end);      

        if (!$result['status']) {
            return Redirect()->back()->with('fail', $result['msg']);
        }

        Acr::create($request->validated());

        return redirect(route('acr.myacrs'));
    }    


    public function edit(Acr $acr)
    {
        abort_if($this->user->employee_id <> $acr->employee_id, 403, $this->msg403);
        if ($acr->isSubmitted()) {
            return Redirect()->back()->with('fail', ' ACR is already Submitted, can not be edited...');
        }

        $acr_selected_group_type = AcrType::where('id', $acr->acr_type_id)->select('description as name', 'group_id', 'id')->first();
        $acr_Types = AcrType::where('group_id', $acr_selected_group_type->group_id)->select('description as name', 'id')->get();
        $acr_office = Office::where('id', $acr->office_id)->select('office_type', 'name', 'id')->first();
        $Offices = Office::select('name', 'id')->get();
        $employee = Employee::findOrFail($this->user->employee_id);
        $Officetypes = $this->defineOfficeTypes();
        $acrGroups = $this->defineAcrGroup();

        return view('employee.acr.edit', compact(
            'acr',
            'acr_selected_group_type',
            'acr_Types',
            'acr_office',
            'Offices',
            'employee',
            'Officetypes',
            'acrGroups'
        ));
    }

    public function update(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        abort_if($this->user->employee_id <> $acr->employee_id, 403, $this->msg403);

        $start = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
        $end = Carbon::createFromFormat('Y-m-d', $request->to_date)->startOfDay();

        $result =Employee::findOrFail($acr->employee_id)->checkAcrDateInBetweenPreviousACRFilled($start, $end, $request->acr_id);  
        if (!$result['status']) {
            return Redirect()->back()->with('fail', $result['msg']);
        }

        $acr->update([
            'acr_group_id' => $request->acr_group_id,
            'acr_type_id' => $request->acr_type_id,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'office_id' => $request->office_id,
            'property_filing_return_at' => $request->property_filing_return_at,
            'professional_org_membership' => $request->professional_org_membership
        ]);

        return redirect(route('acr.myacrs'));
    }

    public function showPart1(Acr $acr)
    {
        abort_if($this->user->employee_id <> $acr->employee_id, 403, $this->msg403);
        list($employee, $appraisalOfficers, $leaves, $appreciations, $inbox, $reviewed, $accepted, $officeWithParentList) = $acr->firstFormData();

        return view('employee.acr.view_part1', compact(
            'acr',
            'employee',
            'appraisalOfficers',
            'leaves',
            'appreciations',
            'inbox',
            'reviewed',
            'accepted',
            'officeWithParentList'
        ));
    }

    public function addOfficers(Acr $acr)
    {
        $permission = false;
        if ($acr->is_defaulter  && $this->user->hasPermissionTo(['create-others-acr'])) {
            $permission = true;
        }
        if (!$permission) {
            abort_if($this->user->employee_id <> $acr->employee_id, 403, $this->msg403);
        }
        $appraisalOfficers =  $acr->appraisalOfficers()->get()->groupBy('pivot.appraisal_officer_type')->sortBy('pivot.from_date');

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

        $permission = false;
        if ($acr->is_defaulter && $this->user->hasPermissionTo(['create-others-acr'])) {
            $permission = true;
        }
        if (!$permission) {
            abort_if($this->user->employee_id <> $acr->employee_id, 403, $this->msg403);
        }

        $appraisal_officer_type = $request->appraisal_officer_type;

        if ($this->user->employee_id == $request->appraisal_officer_type) {
            return Redirect()->back()->with('fail', 'You cannot submit ACR to Yourself...');
        }

        $startDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->startOfDay();

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
        abort_if($this->user->employee_id <> $acr->employee_id, 403, $this->msg403);
        if ($acr->isSubmitted()) {
            return Redirect()->back()->with('fail', ' ACR is already Submitted, Thus No Offcials can be deleted...');
        }
        $acr->appraisalOfficers()->wherePivot('appraisal_officer_type', $request->appraisal_officer_type)->detach();
        return Redirect()->back()->with('success', 'Officer deleted Successfully...');
    }

    public function submitAcr(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);

        $permission = false;
        if ($acr->is_defaulter && $this->user->hasPermissionTo(['create-others-acr'])) {
            $permission = true;
        }
        if (!$permission) {
            abort_if($this->user->employee_id <> $acr->employee_id, 403, $this->msg403);           
        }

        $result = $acr->checkSelfAppraisalFilled();
        if (!$result['status']) {
            return Redirect()->back()->with('fail', $result['msg']);
        }
        if (!$acr->isDurationMatches) {
            return Redirect()->back()->with('fail', 'Appraisal officer date not matches, please revisit your data');
        }
        $acr->update(['submitted_at' => now()]);
        dispatch(new MakeAcrPdfOnSubmit($acr, 'submit'));

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);

        abort_if($acr->submitted_at, 403, 'ACR is already submitted so it can not be deleted');

        $acr->delete();

        return redirect()->back()->with('success','ACR deleted Successfully');
    }




    public function show(Acr $acr)
    {
        //own or some admin
        if ($acr->permissionForPdf()) {

            if ($acr->isFileExist()) {
                $headers = [
                    'Content-Description' => 'File Transfer',
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . $acr->id . '.pdf"'
                ];
                //return Response::make(file_get_contents($acr->pdfFullFilePath), 200, $headers);

                return response()->file($acr->pdfFullFilePath, $headers);
            } else {
                return Redirect()->back()->with('fail', 'Acr File does not exist');
            }
        }
        return abort(403, 'Unauthorized action.You are not authorised to see this ACR details');
    }


    public function addLeaves(Acr $acr)
    {
        abort_if($this->user->employee_id <> $acr->employee_id, 403, $this->msg403);
        $leaves = Leave::where('acr_id', $acr->id)->get();
        return view('employee.acr.add_leaves', compact('acr', 'leaves'));
    }


    public function addAcrLeaves(StoreAcrLeaveRequest $request) // 
    {

        $acr = Acr::findOrFail($request->acr_id);
        abort_if($this->user->employee_id <> $acr->employee_id, 403, $this->msg403);

        $start = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
        $end = Carbon::createFromFormat('Y-m-d', $request->to_date)->startOfDay();

        $result = $acr->checkisDateInBetween($start, $end);
        if (!$result['status']) {
            return Redirect()->back()->with('fail', $result['msg']);
        }

        Leave::create($request->validated());

        return redirect(route('acr.addLeaves', ['acr' => $acr->id]))->with('success', 'Leave added Sucessfully');
    }



    public function deleteAcrLeaves(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        abort_if($this->user->employee_id <> $acr->employee_id, 403, $this->msg403);
        if ($acr->isSubmitted()) {
            return Redirect()->back()->with('fail', ' ACR is already Submitted, Thus Leaves can not be deleted...');
        }
        Leave::find($request->leave_id)->delete();

        return Redirect()->back()->with('success', 'Leave deleted Successfully...');
    }

    public function addAppreciation(Acr $acr)
    {
        abort_if($this->user->employee_id <> $acr->employee_id, 403, $this->msg403);
        $appreciations = Appreciation::where('acr_id', $acr->id)->get();

        return view('employee.acr.add_Appreciation', compact('acr', 'appreciations'));
    }

    public function addAcrAppreciation(Request $request)
    {
        // validate Appreciation_request
        $this->validate(
            $request,
            [
                'acr_id' => 'required',
                'appreciation_type' => 'required',
                'detail' => 'required'
            ]
        );
        $acr = Acr::findOrFail($request->acr_id);
        abort_if($this->user->employee_id <> $acr->employee_id, 403, $this->msg403);

        Appreciation::create($request->all());

        return redirect(route('acr.addAppreciation', ['acr' => $request->acr_id]))->with('success', 'Appreciation added Sucessfully');
    }

    public function deleteAcrAppreciation(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        abort_if($this->user->employee_id <> $acr->employee_id, 403, $this->msg403);
        if ($acr->isSubmitted()) {
            return Redirect()->back()->with('fail', ' ACR is already Submitted, Thus Appreciations can not be deleted...');
        }
        Appreciation::find($request->appreciation_id)->delete();

        return Redirect()->back()->with('success', 'Appreciation deleted Successfully...');
    }
}
