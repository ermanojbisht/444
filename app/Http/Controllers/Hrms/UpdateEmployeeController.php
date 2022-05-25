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
        $OfficesAllocated = $this->user->OfficeToAnyJob(['employee_edit_job']); // hr-gr-draft for Draft Answer
        $newAddedEmployees = Employee::whereIn("current_office_id", $OfficesAllocated)->whereIn('lock_level', [1, 2])->get();

        return view('hrms.employee.index', compact('newAddedEmployees'));
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
}
