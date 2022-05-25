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

class HrmsEmployeeController extends Controller
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
        $newAddedEmployees = Employee::where('lock_level', "0")->get();;

        return view('hrms.employee.index', compact('newAddedEmployees'));
    }

    /**
     * [create new Employee ]
     * @return view for Employee creation
     */
    public function create()
    {
        //$offices = Office::select('name', 'id')->orderBy('name')->get();
        $title = "Create new Employee";

        return view('hrms.employee.create', compact('title'));
    }

    /**
     * [store Employee Data]
     * @param  StoreEmployeeRequest $request [Employee Data]
     * @return [type]               redirect [New Added Employee Index]
     */
    public function store(StoreEmployeeRequest $request)
    {
        $employee = Employee::create($request->validated());

        return redirect('employee/index')->with('status', 'Employee Added Successfully!');
    }

    /**
     * [edit Employee Data Level 1]
     * @return view for Employee editing
     */
    public function edit(Employee $employee)
    {

        $designations = array('' => 'Select Designation') + Designation::where('group_id', '!=', 'null')
            ->orderBy('name')->pluck('name', 'id')->toArray();

        $offices = array('' => 'Select Office') + Office::orderBy('name')->pluck('name', 'id')->toArray();


        return view('hrms.employee.edit', compact('employee', 'designations', 'offices'));
    }


    /**
     * [update Employee Data]
     * @param  UpdateEmployeeRequest $request [Employee Data]
     * @return [type]               redirect [New Added Employee Index]
     */
    public function update(UpdateEmployeeRequest $request)
    {

        $employee = Employee::findorFail($request->id);
        $employee->update($request->validated());

        return redirect('employee/index')->with('status', 'Employee Updated Successfully!');
    }


    /**
     * [lock Employee Data Level Wise]
     * @param Request $request [Lock Levels Request] 
     */
    public function lockEmployee(Employee $employee, $lock_level)
    {
        if ($lock_level == 1) {
            if (!$employee->current_designation_id)
                return redirect()->back()->with('fail', "Please Enter Designation.");
            if (!$employee->current_office_id)
                return redirect()->back()->with('fail', "Please Enter Office Name.");
        }

        $employee->update(['lock_level' => $lock_level]);

        return redirect('employee/index')->with('status', 'Employee Added Successfully!');
    }
}
