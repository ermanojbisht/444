<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CeOffice;
use App\Models\EeOffice;
use App\Models\Office;
use App\Models\OfficeJob;
use App\Models\OfficeJobDefault;
use App\Models\SeOffice;
use App\Models\User;
use Auth;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OfficeJobDefaultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $user;
    /**
     * @var mixed
     */
    protected $jobWhichNeedSingleUser;
    /**
     * @return mixed
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::User();
            $this->jobWhichNeedSingleUser = [1, 2, 3];
            return $next($request);
        });
    }

    public function index()
    {
        abort_if(Gate::denies('office_job_default_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $officeJobDefaults = OfficeJobDefault::with(['user', 'jobType', 'Office'])->get();

        return view('admin.officeJobDefaults.index', compact('officeJobDefaults'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jobs = OfficeJob::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $offices = Office::all();

        return view('admin.officeJobDefaults.create', compact('jobs', 'offices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $selectedUser = User::whereEmployeeId($request->employee_id)->first();
        if ($selectedUser) {
            $request->merge(['user_id' => $selectedUser->id]);
            $this->validate($request,
                [
                    'office_id' => 'required',
                    'job_id' => 'required',
                    'employee_id' => 'required'
                ]);
            //office head should be only one in office or similar job
            if (in_array($request->job_id, $this->jobWhichNeedSingleUser)) {
                $OfficeHeadJobRowExist = OfficeJobDefault::whereJobId($request->job_id)->whereOfficeId($request->office_id)->first();
                if ($OfficeHeadJobRowExist) {
                    return redirect()->back()->with('fail', "Office head/ similar one person row already exist for selected office . you can't add more then one head for a office. Delete existing row then add new one");
                }
            }
        } else {
            return redirect()->back()->with('fail', "User with employee Id $request->employee_id does't exist");
        }

        $OfficeJob = OfficeJobDefault::create($request->all());
        //head_emp_code will also change in office tables
        $OfficeJob->updateHeadEmpCodeInOfficeTables();

        return redirect()->route('admin.office-job-defaults.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OfficeJobDefault $officeJobDefault
     * @return \Illuminate\Http\Response
     */
    public function show(OfficeJobDefault $officeJobDefault)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OfficeJobDefault $officeJobDefault
     * @return \Illuminate\Http\Response
     */
    public function edit(OfficeJobDefault $officeJobDefault)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request     $request
     * @param  \App\Models\OfficeJobDefault $officeJobDefault
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OfficeJobDefault $officeJobDefault)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OfficeJobDefault $officeJobDefault
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfficeJobDefault $officeJobDefault)
    {
        $officeJobDefault->delete();

        return redirect()->route('admin.office-job-defaults.index')->with('success', 'Data deleted');
    }

    public function bulkUpdateOfficeHeadJob()
    {
        (new CeOffice)->bulkUpdateHeadEmpAsUserInJobTable();
        (new EeOffice)->bulkUpdateHeadEmpAsUserInJobTable();
        (new SeOffice)->bulkUpdateHeadEmpAsUserInJobTable();
        return redirect()->back()->with('success', 'Data updated');

    }
}

/**
 * todo route('bulkUpdateOfficeHeadJob')
 */
