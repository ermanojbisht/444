<?php

namespace App\Http\Controllers\Hrms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\Hrms\StorePostingsRequest;
use App\Http\Requests\Employee\Hrms\UpdatePostingDetailsRequest;
use App\Http\Requests\Employee\Hrms\UpdatePostingsRequest;
use App\Models\Designation;
use App\Models\Hrms\Employee;
use App\Models\Hrms\Posting;
use App\Models\Office;
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

        return view('hrms.employee.posting.create', compact('employee', 'employeePostings', 'designations', 'offices', 'isLastPostingClosed'));
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

        return redirect()->route('employee.posting.create', ['employee' => $request->employee_id])
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

        abort_if($posting->from_date->gt($end_date), 403, ' End Date ' . $end_date->format('d M Y') . ' cannot be greater then posting start Date' . $posting->from_date->format('d M Y'));

        $posting->update([
            'to_date' => $request->to_date
        ]);

        $posting->saveSugamDurgamPeriod();
        $posting->employee->updateSugamDurgam();
        return redirect()->back()->with('success', 'End Date Added Successfully');
    }


    public function edit(Posting $posting)
    {

        $employeePostings = $posting->employee->postings()->get();
        //$employeePostings =  $posting->with('office')->with('designation')->get();

        $isLastPostingClosed = ($employeePostings->first()->to_date);

        $designations = array('' => 'Select Designation') + Designation::where('group_id', '!=', 'null')
            ->orderBy('name')->pluck('name', 'id')->toArray();

        $offices = array('' => 'Select Office') + Office::orderBy('name')->pluck('name', 'id')->toArray();

        $nextPosting = $posting->employee->nextPostings($posting->id);
        $prevposting = $posting->employee->previousPostings($posting->id);

        return view('hrms.employee.posting.edit', compact(
            'posting',
            'prevposting',
            'nextPosting',
            'designations',
            'offices',
            'isLastPostingClosed'
        ));
    }

    public function update(UpdatePostingDetailsRequest $request)
    {
        $posting = Posting::find($request->id);

        $from_date = Carbon::parse($request->from_date);
        $end_date = Carbon::parse($request->to_date);

        abort_if($from_date->gte($end_date), 403, ' End Date ' . $end_date->format('d M Y') .
            ' cannot be less or equals then posting start Date ' . $posting->from_date->format('d M Y'));

        $prevposting = $posting->employee->previousPostings($request->id);
        if ($prevposting) {
            abort_if($from_date->lte($prevposting->to_date), 403, ' From Date ' . $from_date->format('d M Y') .
                ' cannot be less then or equals previous posting End Date ' . $prevposting->to_date->format('d M Y'));
        }

        $nextPosting = $posting->employee->nextPostings($request->id);
        if ($nextPosting) {
            abort_if($end_date->gte($nextPosting->from_date), 403, ' End Date ' . $end_date->format('d M Y') .
                ' cannot be greater then or equals next posting From Date ' . $nextPosting->from_date->format('d M Y'));
        }


        if ($posting->from_Date != $from_date || $posting->to_Date != $end_date) {


            $posting->update([
                'order_no' =>  $request->order_no,
                'order_at' =>  $request->order_at,
                'from_date' =>  $request->from_date,
                'to_date' =>  $request->to_date,
                'office_id' =>  $request->office_id,
                'designation_id' =>  $request->designation_id
            ]);


            $posting->saveSugamDurgamPeriod();

            if ($prevposting) {
                $prevposting->update([
                    'to_date' => $from_date->subDay()
                ]);
                $prevposting->saveSugamDurgamPeriod();
            }

            if ($nextPosting) {

                $nextPosting->update([
                    'from_date' => $end_date->addDay()
                ]);
                $nextPosting->saveSugamDurgamPeriod();
            }

            $posting->employee->updateSugamDurgam();
        } else {
            $posting->update([
                'order_no' =>  $request->order_no,
                'order_at' =>  $request->order_at,
                'office_id' =>  $request->office_id,
                'designation_id' =>  $request->designation_id
            ]);
        }


        return redirect()->route('employee.posting.create', ['employee' => $request->employee_id])
            ->with('status', 'Postings Updated Successfully!');
    }

    /* View Delete Posting View Page */
    public function delete(Posting $posting)
    {

        $employeePostings = $posting->employee->postings()->get();
        //$employeePostings =  $posting->with('office')->with('designation')->get();

        $isLastPostingClosed = ($employeePostings->first()->to_date);

        $designations = array('' => 'Select Designation') + Designation::where('group_id', '!=', 'null')
            ->orderBy('name')->pluck('name', 'id')->toArray();

        $offices = array('' => 'Select Office') + Office::orderBy('name')->pluck('name', 'id')->toArray();

        $nextPosting = $posting->employee->nextPostings($posting->id);
        $prevposting = $posting->employee->previousPostings($posting->id);

        return view('hrms.employee.posting.delete', compact('posting',  'prevposting', 'nextPosting', 'designations', 'offices', 'isLastPostingClosed'));
    }


    /* Request to Delete -> Selected Posting  */
    public function deletePosting(Posting $posting)
    {

        $posting = Posting::find($posting->id);

        $prevposting = $posting->employee->previousPostings($posting->id);
        $nextPosting = $posting->employee->nextPostings($posting->id);


        // if ($prevposting) {
        //     $prevposting->update([
        //         'to_date' => $nextPosting->from_date
        //     ]);
        //     $prevposting->saveSugamDurgamPeriod();
        // }

        if ($nextPosting) {
            $nextPosting->update([
                'from_date' => $prevposting->to_date->addDay()
            ]);
            $nextPosting->saveSugamDurgamPeriod();
        }

        $posting->delete();

        $posting->employee->updateSugamDurgam();

        return redirect()->route('employee.posting.create', ['employee' => $posting->employee->id])
            ->with('status', 'Postings Updated Successfully!');
    }
}
