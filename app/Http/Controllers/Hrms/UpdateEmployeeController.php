<?php

namespace App\Http\Controllers\Hrms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\Hrms\StoreEmployeeRequest;
use App\Http\Requests\Employee\Hrms\UpdateEmployeeRequest;
use App\Models\Designation;
use App\Models\Hrms\Employee;
use App\Models\Office;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Redirect;
use Request;

class UpdateEmployeeController extends Controller
{

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

    // view all employees in Office
    public function index()
    {
        $title = "Office Enrolled Employees";
        $OfficesAllocated = $this->user->OfficeToAnyJob(['edit_employee_job']); // hr-gr-draft for Draft Answer
        $newAddedEmployees = Employee::where('retirement_date','>',now())->whereIn("office_idd", $OfficesAllocated)->whereIn('lock_level', [1, 2])
        ->with('designationName')->get();

        return view('hrms.employee.index', compact('newAddedEmployees', 'title'));
    }


    /**
     * [view Employee ]
     * @return      Employee 
     */
    public function view(Employee $employee)
    {
        $title = "Create new Employee";
        $designations = array('' => 'Select Designation') + Designation::where('group_id', '!=', 'null')
            ->orderBy('name')->pluck('name', 'id')->toArray();

        $offices = array('' => 'Select Office') + Office::orderBy('name')->pluck('name', 'id')->toArray();


        return view('hrms.employee.view', compact('title', 'employee', 'designations', 'offices'));
    }

 
    /**
     ** Add Basic Details
     * [view edit Employee Data] by Office 
     * @return view for Employee editing
     */
    public function editBasicDetails(Employee $employee)
    {
        $designations = array('' => 'Select Designation') + Designation::whereNotNull('group_id')->
        orderBy('name')->pluck('name', 'id')->toArray();
         
        $offices = array('' => 'Select Office') + Office::orderBy('name')->pluck('name', 'id')->toArray();
        return view('hrms.employee.edit_all', compact('employee', 'designations', 'offices'));
    }


    /**
     * [update Employee Data] by Office
     * @param  UpdateEmployeeRequest $request [Employee Data]
     * @return [type]               redirect [New Added Employee Index]
     */
    public function updateBasicDetails(UpdateEmployeeRequest $request)
    {
        $employee = Employee::findorFail($request->id);
        $employee->update($request->validated());

        return redirect()->route('employee.office.view',['employee'=>$employee->id])
        ->with('status', 'Employee Updated Successfully!');
    }


}
