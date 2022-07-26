<?php

namespace App\Http\Controllers\Hrms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\Hrms\StoreAddressRequest;
use App\Http\Requests\Employee\Hrms\StoreEmployeeRequest;
use App\Http\Requests\Employee\Hrms\StorePostingsRequest;
use App\Http\Requests\Employee\Hrms\UpdateEmployeeRequest;
use App\Models\Designation;
use App\Models\Hrms\Address;
use App\Models\Hrms\Constituency;
use App\Models\Hrms\District;
use App\Models\Hrms\Education;
use App\Models\Hrms\Employee;
use App\Models\Hrms\Posting;
use App\Models\Hrms\State;
use App\Models\Office;
use App\Models\Tehsil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Redirect;
 

class PostingController extends Controller
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
    public function createPostings(Employee $employee)
    {
         $employeePostings = Posting::where("employee_id", $employee->id)
      ->with('officeName')->with('designationName')->get();
        
        $designations = array('' => 'Select Designation') + Designation::where('group_id', '!=', 'null')
        ->orderBy('name')->pluck('name', 'id')->toArray();
        
        $offices = array('' => 'Select Office') + Office::orderBy('name')->pluck('name', 'id')->toArray();


        return view('hrms.employee.createPostings', compact('employee','employeePostings', 'designations', 'offices'));    
    }


    /**
     ** Add Address Details
     * [view Employee Add Address ] by Office 
     * @return view for Employee Add Address 
     */
    public function storePostings(StorePostingsRequest $request)
    {
        $lastPosting = Posting::where("employee_id",$request->employee_id)->whereNull("to_date");
        $lastPosting->update(['to_date' => $request->to_date ]);

        $newPosting = $request->validated();
        $newPosting['to_date'] = NUll;
        
        Posting::create($newPosting);
        
        return redirect()->route('employee.createPostings',['employee'=>$request->employee_id])
        ->with('status', 'Postings Updated Successfully!'); 
        
        // return redirect()->back()->with('status', 'Employee Added Successfully!');

    }

    


}
