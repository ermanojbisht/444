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

class EditEmployeeHqController extends Controller
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
     * [edit Employee Status => Office => Designation => Head Quarter]
     * @return view for Employee Updatetion
     */
    public function edit()
    {

        $isA_allowed = "";
        $isB_allowed = "";
        $isC_allowed = "";
        $isD_allowed = "";

        if ($this->user->OfficeToAnyJob(['a_level_job'])) {
            $isA_allowed = "A";
        }
        if ($this->user->OfficeToAnyJob(['b_level_job'])) {
            $isB_allowed = "B";
        }
        if ($this->user->OfficeToAnyJob(['c_level_job'])) {
            $isC_allowed = "C";
        }
        if ($this->user->OfficeToAnyJob(['d_level_job'])) {
            $isD_allowed = "D";
        }

        $designations = array('' => 'Select Designation') + Designation::whereIn("section", [$isA_allowed, $isC_allowed, $isD_allowed, $isB_allowed])
            ->whereNotNull('group_id')->orderBy('name')->pluck('name', 'id')->toArray();
   
        $offices = array('' => 'Select Office') + Office::orderBy('name')->pluck('name', 'id')->toArray();

        $title = " जिन अधिकारियों/कर्मचारियों का ट्रान्सफर / परमोसन हो गया है उनका ऑफिस यहाँ से अपडेट कर सकते हैं। ";

        return view('hrms.employee.update_employee_status', compact('title', 'designations', 'offices'));
    }


    /**
     * [update Employee Data]
     * @param  UpdateEmployeeRequest $request [Employee Data]
     * @return [type]               redirect [New Added Employee Index]
     */
    public function update(SectionUpdateEmployeePostingRequest $request)
    {
        $employee = Employee::findorFail($request->id);
        $employee->update($request->validated());

        return redirect('employee/index')->with('status', 'Employee Updated Successfully!');
    }

    /**
     * [Get Employee Designationwise => Index]
     * @return view for Employee Update
     */
    public function  getEmployeesDesignationWise(Request $request)
    {
        $employees = Employee::where("designation_id", $request->designation_id)
            ->orderBy('name')->select('name', 'id')->get();

        return $employees;
    }
}
