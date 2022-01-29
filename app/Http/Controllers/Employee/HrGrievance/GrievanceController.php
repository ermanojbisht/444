<?php

namespace App\Http\Controllers\Employee\HrGrivance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Track\Grivance\StoreGrivanceRequest;
use App\Http\Requests\Track\Grivance\UpdateGrivanceRequest;
use App\Models\EeOffice;
use App\Models\Employee;
use App\Models\Track\Grivance\HrGrivance;
use App\Models\Track\Grivance\HrGrivanceType;
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
        $employee = Employee::find($this->user->id);
        $grivances =  $employee->grivances()->get();  // HrGrivance::where("employee_id", $this->user->id);
        return view('employee.hr_grivance.index', compact('employee_name','grivances'))->with('success', 'Grivance added Successfu!lly !!');
    }

    /**
     * [create new Grivance ]
     * @return view for Grivance creation
     */
    public function create()
    {
        $grivanceTypes = HrGrivanceType::all();
        $eeOffices = EeOffice::select(['id', 'name'])->whereIn('div_type', [1, 2])->get();
        return view('employee.hr_grivance.create', compact('grivanceTypes', 'eeOffices'));
    }
 
    /**
     * [store description]
     * @param  StoreGrivanceRequest $request [description]
     * @return [type]                        [description]
     */
    public function store(StoreGrivanceRequest $request)
    {
        $hrGrivance = HrGrivance::create($request->validated());
        if ($request->is_document_upload == 1)
            return Redirect::route("employee.hr_grivance.addDoc", ['hr_grivance' => $hrGrivance->id]);
        else
            return Redirect::route('employee.hr_grivance')->with('success' , $this->textMessageAfterAddingGrivance($hrGrivance->id, 'added'));
    }

    public function textMessageAfterAddingGrivance($hrGrivance_id, $actionCompleted)
    {
        return  'Your Grivance has been ' . $actionCompleted . ', please note down your Grivance Id : ' . $hrGrivance_id . '\n Kindly note this Id for future reference. \n you can add doc \n '.
        ' 2 days editable '; 
    } 


    /**
     * Display the specified Grivance.
     *
     * @param  \App\Models\Track\Grivance\HrGrivance
     * @return \Illuminate\Http\Response
     */
    public function show(HrGrivance $hr_grivance)
    {
        return view('employee.hr_grivance.view', compact('hr_grivance'));
    }


    /**
     * Edit the specified Grivance.
     *
     * @param  \App\Models\Track\Grivance\HrGrivance
     * @return View 
     */
    public function edit(HrGrivance $hr_grivance)
    {
        $grivanceTypes = HrGrivanceType::all();
        $officeType = $hr_grivance->office_type;
        $eeOffices =  $this->officeListAsPerOfficeTypeObject($officeType);
        return view('employee.hr_grivance.edit', compact('hr_grivance', 'grivanceTypes', 'eeOffices'));
    }

    /**
     * Update the specified Grivance.
     *
     * @param  \App\Models\Track\Grivance\HrGrivance
     * @return Redirection to View updated Grivance  
     */
    public function update(UpdateGrivanceRequest $request)
    {
        $hr_grivance = HrGrivance::findorFail($request->grivance_id);
        $hr_grivance->update($request->validated());
        return Redirect::route('employee.hr_grivance')->with('success' , $this->textMessageAfterAddingGrivance($hr_grivance->id, 'update'));
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
