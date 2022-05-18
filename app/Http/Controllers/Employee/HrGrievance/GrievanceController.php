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
use App\Models\OfficeJob;
use App\Models\OfficeJobDefault;
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
        $grievanceTypes = HrGrievanceType::all();  // $eeOffices =  EeOffice::select(['id', 'name'])->whereIn('div_type', [1, 2])->get();
        $eeOffices = Office::select('name', 'id')->orderBy('name')->get();
        return view('employee.hr_grievance.create', compact('grievanceTypes', 'eeOffices'));
    }

    /**
     * [store description]
     * @param  StoreGrievanceRequest $request [description]
     * @return [type]                        [description]
     */
    public function store(StoreGrievanceRequest $request)
    {
        if(!Office::find($request->office_id)->getFinalGriveanceResolver())
        {
            return redirect()->back()->with('fail', 'No Officer is Selected to resolve Grievances in the 
            selected Office, thus cannot add Grievances in this Office'); 
        } 
        $hrGrievance = HrGrievance::create($request->validated());

        if ($request->is_document_upload == 1)
            return Redirect::route("employee.hr_grievance.addDoc", ['hr_grievance' => $hrGrievance->id]);
        else
            return Redirect::route('employee.hr_grievance')->with(
                'success',
                $this->textMessageAfterAddingGrievance($hrGrievance->id, 'Created Successfully')
            );
    }

    public function textMessageAfterAddingGrievance($hrGrievance_id, $actionCompleted)
    {
        return  'Your Grievance has been ' . $actionCompleted . ', Please note down your Grievance Id : ' . $hrGrievance_id .
            '.  Kindly note this Id for future reference. Application will remain editable till you submit the Grievance.';
    }

    public function submit(Request $request)
    {
        $hrGrievance = HrGrievance::findOrFail($request->grievance_id);
        $hrGrievance->update(['status_id' => 1]);
        $hrGrievance->notificationFor('submit');
        return Redirect::route('employee.hr_grievance')->with('success', 'Application Submitted Successfully');
    }

    public function reopen(Request $request)
    {
        $hrGrievance = HrGrievance::findOrFail($request->grievance_id);
        $hrGrievance = HrGrievance::create(
            [
                'grievance_type_id' => $hrGrievance->grievance_type_id,
                'subject' => $hrGrievance->subject . ' Reopened from Grievance id ' . $hrGrievance->id,
                'description' => $hrGrievance->description,
                'office_type' => $hrGrievance->office_type,
                'office_id' => $hrGrievance->office_id,
                'employee_id' => $hrGrievance->employee_id,
                'refference_grievance_id' => $hrGrievance->id,
                'status_id' => 0
            ]
        );
        return Redirect::route('employee.hr_grievance')->with('success', 'Application Reopened Successfully');
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
         
        $eeOffices = Office::select('name', 'id')->orderBy('name')->get();
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
        if(!Office::find($request->office_id)->getFinalGriveanceResolver())
        {
            return redirect()->back()->with('fail', 'No Officer is Selected to resolve Grievances in the 
            selected Office, thus cannot add Grievances in this Office'); 
        } 

        $hr_grievance = HrGrievance::findorFail($request->grievance_id);
        $hr_grievance->update($request->validated());

        return Redirect::route('employee.hr_grievance')->with('success',
            $this->textMessageAfterAddingGrievance($hr_grievance->id, 'Updated Successfully')
        );
       
    }
 
    /**
     * Ajax Call for Grievance Resolver in office.
     *
     * @param  \App\Models\ Offices 
     * @return Office List   
     */
    public function getFinalResolverOfOffice(Request $request)
    {
        return Office::find($request->office_id)->getFinalGriveanceResolver();  
    }


}
