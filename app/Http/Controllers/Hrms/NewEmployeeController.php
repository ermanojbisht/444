<?php

namespace App\Http\Controllers\Hrms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\Hrms\SectionStoreEmployeeRequest;
use App\Http\Requests\Employee\Hrms\SectionUpdateEmployeePostingRequest;
use App\Http\Requests\Employee\Hrms\SectionUpdateEmployeeRequest;
use App\Http\Requests\Employee\Hrms\UpdateEmployeeRequest;
use App\Models\Designation;
use App\Models\Hrms\Employee;
use App\Models\Hrms\Posting;
use App\Models\Office;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Redirect;

class NewEmployeeController extends Controller
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
        $user = Auth::User();
        if (Auth::user()->hasAccess(['create_employee'])) {

            $title = "New Enrolled Employees";
            $newAddedEmployees = Employee::where('lock_level', "0")
                ->orWhere('designation_id', 'null')->get();


            $newAddedEmployees = Employee::where('retirement_date', '>', now())
                ->where('lock_level', 0)->with('designationName')->get();

            //->whereIn("office_idd", $OfficesAllocated)
            // ->orwhere("office_idd", 0)
            return view('hrms.employee.index', compact('newAddedEmployees', 'title'));
        } else {
           
            return redirect()->route('employee.office.index'); 
        }
    }

    /**
     * [create new Employee ]
     * @return view for Employee creation
     */
    public function create()
    {
        $designations = array('' => 'Select Designation') + Designation::where('group_id', '!=', 'null')
            ->orderBy('name')->pluck('name', 'id')->toArray();
        $offices = array('' => 'Select Office') + Office::orderBy('name')->pluck('name', 'id')->toArray();
        $title = "Create new Employee";

        return view('hrms.employee.new_entry.create', compact('title', 'designations', 'offices'));
    }

    /**
     * [store Employee Data]
     * @param SectionStoreEmployeeRequest  $request [Employee Data]    StoreEmployeeRequest
     * @return [type]               redirect [New Added Employee Index]
     */
    public function store(SectionStoreEmployeeRequest $request)
    {
        $employee = Employee::create($request->validated());

        $employee->updateOfficeRelatedData();
        
        $posting = Posting::create([
            'employee_id' => $request->id,
            'order_no' =>  $request->appointment_order_no,
            'order_at' => $request->appointment_order_at,
            'office_id' => $request->office_idd,
            'from_date' => $request->joining_date,
            'mode_id' => "13",
            'designation_id' => $request->designation_id,
            'is_prabhari' => '0',
            'islocked' => "1",
            'row_confirm' => "1"
        ]);



        return redirect('employee/index')->with('status', 'Employee Added Successfully!');
    }

    /**
     * [edit Employee Data Level 1]
     * @return view for Employee editing
     */
    public function edit(Employee $employee)
    {
        $designations = array('' => 'Select Designation') + Designation::whereNotNull('group_id')->orderBy('name')->pluck('name', 'id')->toArray();

        $offices = array('' => 'Select Office') + Office::orderBy('name')->pluck('name', 'id')->toArray();

        return view('hrms.employee.new_entry.edit', compact('employee', 'designations', 'offices'));
    }


    /**
     * [update Employee Data]
     * @param  UpdateEmployeeRequest $request [Employee Data]
     * @return [type]               redirect [New Added Employee Index]
     */
    public function update(SectionUpdateEmployeeRequest $request)
    {
        $employee = Employee::findorFail($request->employee_id);
        $employee->update($request->validated());

        $posting = Posting::where('employee_id', $request->employee_id);
        $posting->update([
            'employee_id' => $request->id,
            'order_no' =>  $request->appointment_order_no,
            'order_at' => $request->appointment_order_at,
            'office_id' => $request->office_idd,
            'from_date' => $request->joining_date,
            'designation_id' => $request->designation_id
        ]);


        return redirect('employee/index')->with('status', 'Employee Updated Successfully!');
    }

    /**
     * [lock Employee Data Level Wise]
     * @param Request $request [Lock Levels Request] 
     */
    public function lockEmployee(Employee $employee, $lock_level)
    {
        if ($lock_level == 1) {
            if (!$employee->designation_id)
                return redirect()->back()->with('fail', "Please Enter Designation.");
            if (!$employee->office_idd)
                return redirect()->back()->with('fail', "Please Enter Office Name.");
        }

        $employee->update(['lock_level' => $lock_level]);

        return redirect('employee/index')->with('status', 'Employee Added Successfully!');
    }

     
}
