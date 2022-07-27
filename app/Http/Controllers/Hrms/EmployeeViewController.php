<?php

namespace App\Http\Controllers\Hrms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\Hrms\StoreEmployeeRequest;
use App\Http\Requests\Employee\Hrms\UpdateEmployeeRequest;
use App\Models\Designation;
use App\Models\Hrms\Employee;
use App\Models\Hrms\OfficeHeadQuarter;
use App\Models\Hrms\OtherOffice;
use App\Models\Hrms\Posting;
use App\Models\Office;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Redirect;
use Request;

class EmployeeViewController extends Controller
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
     * [view Employee ]
     * @return Employee 
     */
    public function view(Employee $employee)
    {

       /* $all_postings = Posting::all(); // where("employee_id", '010096004')->get();

        foreach ($all_postings as $postings) {

            if ($postings->head_quarter != 0)
                $duration = OfficeHeadQuarter::where("id", $postings->head_quarter)->first()->duration_factor;

            if ($postings->other_office_id != 0)
                $duration = OtherOffice::where("id", $postings->other_office_id)->first()->duration_factor;

            if ($postings->office_id != 0)
                $duration = Office::where("id", $postings->office_id)->first()->duration_factor;

            if ($postings->to_date) {
                $days_in_office = $duration * (int)(Carbon::parse($postings->from_date)->diffInDays(Carbon::parse($postings->to_date)));

                $days_in_office = $days_in_office + 1;

                $postings->update([
                    'days_in_office' => $days_in_office
                ]);
            } 
            //else {
            // $days_in_office =  $duration * (int)Carbon::today()->diffInDays(Carbon::parse($postings->from_date));
            //}


        }

        return "All done"; */


        $designations = array('' => 'Select Designation') + Designation::where('group_id', '!=', 'null')
            ->orderBy('name')->pluck('name', 'id')->toArray();

        $offices = array('' => 'Select Office') + Office::orderBy('name')->pluck('name', 'id')->toArray();

        $employeePostings = Posting::where("employee_id", $employee->id)
            ->with('officeName')->with('designationName')->get();

        $homeAddress = $employee->getAddress(3);

        return view('hrms.employee.show.sugam_durgam', compact(
            'employee',
            'designations',
            'offices',
            'employeePostings',
            'homeAddress'
        ));
    }
}
