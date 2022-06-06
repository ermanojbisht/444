<?php

namespace App\Http\Controllers\Hrms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\Hrms\StoreFamilyRequest;
use App\Models\Hrms\Employee;
use App\Models\Hrms\Family;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Redirect;
use Request;

class FamilyController extends Controller
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
     ** view => Add Family Details
     * [view Employee Family Details ] by Office 
     * @return view for Employee Add family 
     */

    public function createFamilyDetails(Employee $employee)
    {
        $employeeFamily = Family::where("employee_id", $employee->id)->get();

        return view('hrms.employee.createfamily', compact('employee', 'employeeFamily'));
    }


    /**
     ** Store  Family Details
     * [Store Employee Family Details ] by Office 
     * @return view for Employee Add family 
     */
    public function storeFamilyDetails(StoreFamilyRequest $request)
    {
        $employeeFamily = Family::create($request->validated());
        
        return redirect()->back()->with('status', 'Employee Added Successfully!');
    }
}
