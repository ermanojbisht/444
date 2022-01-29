<?php

namespace App\Http\Controllers\Employee\HrGrievance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\HrGrievance\StoreGrivanceRequest;
use App\Http\Requests\Employee\HrGrievance\UpdateGrivanceRequest;
use App\Models\EeOffice;
use App\Models\Employee;
use App\Models\HrGrievance\HrGrievance;
use App\Models\HrGrievance\HrGrievanceType;
use App\Traits\OfficeTypeTrait;
use Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

use Redirect;

class GrievanceController extends Controller
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
            $this->user = Auth::User();
            return $next($request);
        });
    }

    // view all created grivance
    public function index()
    {
        $employee_name = $this->user->name;
        $employee = Employee::find($this->user->employee_id);
        $grivances = $employee->grievances()->get();
        return view('employee.hr_grievance.index', compact('employee_name', 'grivances'))->with('success', 'Grivance added Successfu!lly !!');
    }

    /**
     * [create new Grivance ]
     * @return view for Grivance creation
     */
    public function create()
    {
        $grivanceTypes = HrGrievanceType::all();
        $eeOffices = EeOffice::select(['id', 'name'])->whereIn('div_type', [1, 2])->get();
        return view('employee.hr_grievance.create', compact('grivanceTypes', 'eeOffices'));
    }

    /**
     * [store description]
     * @param  StoreGrivanceRequest $request [description]
     * @return [type]                        [description]
     */
    public function store(StoreGrivanceRequest $request)
    {
        $hrGrivance = HrGrievance::create($request->validated());
        if ($request->is_document_upload == 1)
            return Redirect::route("employee.hr_grievance.addDoc", ['hr_grievance' => $hrGrivance->id]);
        else
            return Redirect::route('employee.hr_grievance')->with('success', $this->textMessageAfterAddingGrivance($hrGrivance->id, 'added'));
    }

    public function textMessageAfterAddingGrivance($hrGrivance_id, $actionCompleted)
    {
        return  'Your Grievance has been ' . $actionCompleted . ', please note down your Grievance Id : ' . $hrGrivance_id . '\n Kindly note this Id for future reference. \n you can add doc \n ' .
            ' 2 days editable ';
    }


    /**
     * Display the specified Grivance.
     *
     * @param  \App\Models\Track\Grivance\HrGrievance
     * @return \Illuminate\Http\Response
     */
    public function show(HrGrievance $hr_grievance)
    {
        return view('employee.hr_grievance.view', compact('hr_grievance'));
    }


    /**
     * Edit the specified Grivance.
     *
     * @param  \App\Models\Track\Grivance\HrGrievance
     * @return View 
     */
    public function edit(HrGrievance $hr_grievance)
    {
        $grivanceTypes = HrGrievanceType::all();
        $officeType = $hr_grievance->office_type;
        $eeOffices =  $this->officeListAsPerOfficeTypeObject($officeType);
        return view('employee.hr_grievance.edit', compact('hr_grievance', 'grivanceTypes', 'eeOffices'));
    }

    /**
     * Update the specified Grivance.
     *
     * @param  \App\Models\Track\Grivance\HrGrievance
     * @return Redirection to View updated Grivance  
     */
    public function update(UpdateGrivanceRequest $request)
    {
        $hr_grievance = HrGrievance::findorFail($request->grivance_id);
        $hr_grievance->update($request->validated());
        return Redirect::route('employee.hr_grievance')->with('success', $this->textMessageAfterAddingGrivance($hr_grievance->id, 'update'));
    }


    /**
     * Ajax Call for Office in office type from trait .
     *
     * @param  \App\Models\CE   \   SE   \   EE Offices 
     * @return Office List   
     */
    public function ajaxDataForOffice(Request $request)
    {
        if ($request->ajax()) {
            $officeType = $request->officeType;
            return $this->officeListAsPerOfficeTypeObject($officeType);
        }
    }
}
