<?php

namespace App\Http\Controllers\Employee\HrGrievance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\HrGrievance\StoreGrievanceRequest;
use App\Http\Requests\Employee\HrGrievance\UpdateGrievanceRequest;

use App\Models\EeOffice;
use App\Models\Employee;
use App\Models\HrGrievance\HrGrievance;
use App\Models\HrGrievance\HrGrievanceType;
use App\Models\Office;
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

    // view all created grievance
    public function index()
    {

        $employee_name = $this->user->name;
        $grievances =  $this->user->grievances()->get();

        return view('employee.hr_grievance.index', compact('employee_name', 'grievances'))->with('success', 'Grievance added Successfu!lly !!');
    }

    /**
     * [create new Grievance ]
     * @return view for Grievance creation
     */
    public function create()
    {
        $grievanceTypes = HrGrievanceType::all();
        // $eeOffices =  EeOffice::select(['id', 'name'])->whereIn('div_type', [1, 2])->get();
        $eeOffices =  Office::where('office_type',3)->select('name','id')->get();
        return view('employee.hr_grievance.create', compact('grievanceTypes', 'eeOffices'));
    }

    /**
     * [store description]
     * @param  StoreGrievanceRequest $request [description]
     * @return [type]                        [description]
     */
    public function store(StoreGrievanceRequest $request)
    {
        $hrGrievance = HrGrievance::create($request->validated());

        if ($request->is_document_upload == 1)
            return Redirect::route("employee.hr_grievance.addDoc", ['hr_grievance' => $hrGrievance->id]);
        else
            return Redirect::route('employee.hr_grievance')->with('success', $this->textMessageAfterAddingGrievance($hrGrievance->id, 'added'));
    }

    public function textMessageAfterAddingGrievance($hrGrievance_id, $actionCompleted)
    {
        return  'Your Grievance has been ' . $actionCompleted . ', please note down your Grievance Id : ' . $hrGrievance_id . '\n Kindly note this Id for future reference. \n you can add doc \n ' .
            ' 2 days editable ';
    }


    /**
     * Display the specified Grievance.
     *
     * @param  \App\Models\Track\Grievance\HrGrievance
     * @return \Illuminate\Http\Response
     */
    public function show(HrGrievance $hr_grievance)
    {
        return view('employee.hr_grievance.view', compact('hr_grievance'));
    }


    /**
     * Edit the specified Grievance.
     *
     * @param  \App\Models\Track\Grievance\HrGrievance
     * @return View 
     */
    public function edit(HrGrievance $hr_grievance)
    {
        $grievanceTypes = HrGrievanceType::all();
        $officeType = $hr_grievance->office_type;
        //  $eeOffices =  $this->officeListAsPerOfficeTypeObject($officeType);
        $eeOffices =  $this->getOfficeListAsPerOfficeTypeId($officeType);
        return view('employee.hr_grievance.edit', compact('hr_grievance', 'grievanceTypes', 'eeOffices'));
    }

    /**
     * Update the specified Grievance.
     *
     * @param  \App\Models\Track\Grievance\HrGrievance
     * @return Redirection to View updated Grievance  
     */
    public function update(UpdateGrievanceRequest $request)
    {
        $hr_grievance = HrGrievance::findorFail($request->grievance_id);
        $hr_grievance->update($request->validated());
        return Redirect::route('employee.hr_grievance')->with('success', $this->textMessageAfterAddingGrievance($hr_grievance->id, 'update'));
    }


    /**
     * Ajax Call for Office in office type from trait .
     *
     * @param  \App\Models\  CE \  SE \  EE Offices 
     * @return Office List   
     */
    public function ajaxDataForOffice(Request $request)
    {
        if ($request->ajax()) {
            $officeType = $request->officeType;
            // return $this->officeListAsPerOfficeTypeObject($officeType);
            return $this->getOfficeListAsPerOfficeTypeId($officeType);
        }
    }
}
