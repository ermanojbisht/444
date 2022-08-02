<?php

namespace App\Http\Controllers\Hrms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\Hrms\StoreAddressRequest;
use App\Http\Requests\Employee\Hrms\StoreEmployeeRequest;
use App\Http\Requests\Employee\Hrms\StorePostingsRequest;
use App\Http\Requests\Employee\Hrms\UpdateEmployeeRequest;
use App\Http\Requests\Employee\Hrms\UpdatePostingsRequest;
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
use Carbon\Carbon;
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
     ** Add Postings Details
     * [view Employee Add Postings ] by Office 
     * @return view for Employee Add Postings 
     */
    public function create(Employee $employee)
    {
        $employeePostings = Posting::where("employee_id", $employee->id)->orderby('from_date', 'DESC')
            ->with('office')->with('designation')->get();

        $isLastPostingClosed = ($employeePostings->first()->to_date);

        $designations = array('' => 'Select Designation') + Designation::where('group_id', '!=', 'null')
            ->orderBy('name')->pluck('name', 'id')->toArray();

        $offices = array('' => 'Select Office') + Office::orderBy('name')->pluck('name', 'id')->toArray();

        return view('hrms.employee.posting.create', compact('employee', 'employeePostings', 'designations', 'offices','isLastPostingClosed'));
    }


    /**
     ** Add Postings Details
     * [Store Employees Postings Details] by Office 
     * @return view for Employee Add Postings 
     */
    public function store(StorePostingsRequest $request)
    {
        $lastPosting = Posting::where("employee_id", $request->employee_id)->whereNull("to_date");
        $lastPosting->update(['to_date' => $request->to_date]);

        $newPosting = $request->validated();
        $newPosting['to_date'] = NUll;

        Posting::create($newPosting);

        return redirect()->route('employee..posting.create', ['employee' => $request->employee_id])
            ->with('status', 'Postings Updated Successfully!');
    }

    /**
     ** Add Postings Details
     * [Update Employees Postings Details] by Office 
     * @return view for Employee Add Postings 
     */
    public function updateRelieving(UpdatePostingsRequest $request)
    {
        $posting = Posting::find($request->id);
        $end_date = Carbon::parse($request->to_date);

        abort_if($posting->from_date->gt($end_date), 403, ' End Date ' . $end_date->format('d m y') . ' cannot be greater then posting start Date' . $posting->from_date->format('d m y'));
        
        $posting->update([
            'to_date' => $request->to_date
        ]);

        $posting->saveSugamDurgamPeriod();
        $posting->employee->updateSugamDurgam();
        return redirect()->back()->with('success', 'End Date Added Successfully');
    }


    public function editPosting(Posting $posting)
    {
        $posting->employee->nextPostings($posting->id);
        $posting->employee->previousPostings($posting->id);
    }

    public function deletePosting(Posting $posting)
    {
        $posting->employee->nextPostings($posting->id);
        $posting->employee->previousPostings($posting->id);
    }


}
