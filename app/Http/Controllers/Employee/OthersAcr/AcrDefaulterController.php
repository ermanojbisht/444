<?php

namespace App\Http\Controllers\Employee\OthersAcr;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acr\StoreAcrRequest;
use App\Models\Acr\Acr;
use App\Models\Acr\AcrRejection;
use App\Models\Acr\AcrType;
use App\Models\Employee;
use App\Models\Office;
use App\Traits\AcrFormTrait;
use App\Traits\OfficeTypeTrait;
use Carbon\Carbon;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcrDefaulterController extends Controller
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
     * @param $id
     * $id => Instance Id
     * To create Acr
     */
    public function index($office_id = 0)
    {
        if ($office_id != 0)
            abort_if(!$this->user->canDoJobInOffice('create-others-acr-job', $office_id), 403, 'You are Not Allowed to view this Office Employees');

        $allowed_Offices = $this->user->OfficeToAnyJob(['create-others-acr-job']);

        $Offices = Office::whereIn('id', $allowed_Offices)->get()->pluck('name', 'id');

        $acrGroups = $this->defineAcrGroup();   

        $defaulters_acrs = Acr::where('is_defaulter', 1)->whereIn('office_id', $allowed_Offices)->get();

        return view('employee.acr.create_others_acr', compact('defaulters_acrs', 'Offices','acrGroups'));
    }

    /**
     * @param $id
     * $id => Instance Id
     * To create Acr
     */
    public function legacyIndex($office_id = 0)
    {
        if ($office_id != 0)
            abort_if(!$this->user->canDoJobInOffice('create-others-acr-job', $office_id), 403, 'You are Not Allowed to view this Office Employees');

        $allowed_Offices = $this->user->OfficeToAnyJob(['create-others-acr-job']);

        $Offices = Office::whereIn('id', $allowed_Offices)->get()->pluck('name', 'id');        

        $legacyAcrs = Acr::where('acr_type_id', 0)->whereIn('office_id', $allowed_Offices)->get();

        return view('employee.acr.create_legacy_acr', compact('legacyAcrs', 'Offices'));
    }

    /**
     * @param $request 
     * To Store Indivitual ACR
     */
    public function store(Request $request)
    {
        // validate appraisal_officer_type 
        $this->validate(
            $request,
            [
                'office_id' => 'required',
                'acr_type_id' => 'required',
                'from_date' => 'required|date',
                'to_date' => 'required|date',
                'employee_id' => 'required' // in AppraisalOfficer acr_id , appraisal_officer_type, employee_id should not be repeated 
            ]
        );

        $employee=Employee::findOrFail($request->employee_id);

        $request->merge([
            'good_work' => 'ACR Not filled by '.$employee->shriName. '. This ACR has been filled as Defaulter\'s ACR.',
            'is_defaulter' => 1
        ]);
              
        $acr = Acr::create($request->all());

       
        return redirect(route('acr.others.defaulters', ['office_id' => 0]));
    }

     /**
     * @param $request 
     * To Store Indivitual ACR
     */
    public function legacystore(Request $request)
    {
        // validate appraisal_officer_type 
        $this->validate(
            $request,
            [
                'office_id' => 'required',
                'acr_type_id' => 'required',
                'from_date' => 'required|date|before:"2022-04-01',
                'to_date' => 'required|date|after_or_equal:from_date|before:"2022-04-01',
                'employee_id' => 'required', // in AppraisalOfficer acr_id , appraisal_officer_type, employee_id should not be repeated 
                'report_no' => 'required|numeric',
                'review_no' => 'required|numeric',
                'accept_no' => 'required|numeric',
                'report_integrity' => 'nullable',                
            ]
        );

        $employee=Employee::findOrFail($request->employee_id);

        /*$request->merge([
            'good_work' => 'ACR Not filled by '.$employee->shriName. '. This ACR has been filled as Defaulter\'s ACR.',
            'is_defaulter' => 1
        ]);*/
              
        $acr = Acr::create($request->all());

       
        return redirect(route('acr.others.legacy', ['office_id' => 0]));
    }


    public function edit(Acr $acr)
    {
        //abort_if($this->user->employee_id <> $acr->employee_id, 403, $this->msg403);
        abort_if($acr->acr_type_id <> '0', 403, 'Only Defaulter ACR can only be edited here...');
        
        if ($acr->isSubmitted()) {
            return Redirect()->back()->with('fail', ' ACR is already Submitted, can not be edited...');
        }

        $acr_selected_group_type = AcrType::where('id', $acr->acr_type_id)->select('description as name', 'group_id', 'id')->first();
        $acr_office = Office::where('id', $acr->office_id)->select('office_type', 'name', 'id')->first();

        $allowed_Offices = $this->user->OfficeToAnyJob(['create-others-acr-job']);
        $Offices = Office::whereIn('id', $allowed_Offices)->get()->pluck('name', 'id');
        // $Offices = Office::select('name', 'id')->get();
        $employee = Employee::findOrFail($this->user->employee_id);
        $Officetypes = $this->defineOfficeTypes();

        return view('employee.acr.edit_defaulters_acr', compact(
            'acr',
            'acr_selected_group_type',
            'acr_office',
            'Offices',
            'employee',
            'Officetypes'           
        ));
    }

    public function update(Request $request)
    {

        $this->validate(
            $request,
            [
                'office_id' => 'required',
                'from_date' => 'required|date',
                'to_date' => 'required|date' 
            ]
        );


        $acr = Acr::findOrFail($request->acr_id);
        //abort_if($this->user->employee_id <> $acr->employee_id, 403, $this->msg403);
        abort_if($acr->acr_type_id <> '0', 403, 'Only Defaulter ACR can only be updated here...');

        $acr->update([ 
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'office_id' => $request->office_id
        ]);

        return redirect(route('acr.others.defaulters', ['office_id' => 0]));
    }



}
