<?php

namespace App\Http\Controllers\Hrms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\Hrms\StoreEducationRequest;
use App\Models\Hrms\Education;
use App\Models\Hrms\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Redirect;
use Request;

class EducationController extends Controller
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

    /**
     ** Add Address Details
     * [view Employee Add Address ] by Office 
     * @return view for Employee Add Address 
     */
    public function createEducations(Employee $employee)
    {
        $employeeEducation = Education::where("employee_id", $employee->id)->get();

        return view('hrms.employee.createEducation', compact('employee','employeeEducation'));
    }


    /**
     ** Add Address Details
     * [view Employee Add Address ] by Office 
     * @return view for Employee Add Address 
     */
    public function storeEducationDetails(StoreEducationRequest $request)
    {
        $employeeAddresss = Education::create($request->validated());

        return redirect()->route('employee.createEducationDetails', ['employee' => $request->employee_id])
            ->with('status', 'Address Updated Successfully!');

        // return redirect()->back()->with('status', 'Employee Added Successfully!');
    }
}
