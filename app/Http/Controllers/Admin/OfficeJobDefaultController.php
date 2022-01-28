<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfficeJobDefaultRequest;
use App\Models\EeOffice;
use App\Models\OfficeJob;
use App\Models\OfficeJobDefault;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Gate;
use Symfony\Component\HttpFoundation\Response;


class OfficeJobDefaultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $user;
    protected $userAllowdOffice;
    protected $userAllowdOfficeWithName;
    function __construct()
    {
       $this->middleware(function ($request, $next) {
        $this->user = Auth::User();
        $this->userAllowdOfficeWithName = Auth::User()->onlyEEOffice();
        $this->userAllowdOffice = $this->userAllowdOfficeWithName->pluck('id');
        //array to object
        //$this->userAllowdOfficeWithName=json_decode(json_encode($this->userAllowdOfficeWithName), FALSE);
        return $next($request);
       });
       
    }
    public function index()
    {
        abort_if(Gate::denies('office_job_default_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $officeJobDefaults = OfficeJobDefault::with(['user', 'jobType','eeOffice'])->get();
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
       $users = User::all();
       $offices = EeOffice::all();
       return view('admin.officeJobDefaults.create',compact('jobs','users','offices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $OfficeJob = OfficeJobDefault::create($request->all());

        return redirect()->route('admin.office-job-defaults.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OfficeJobDefault  $officeJobDefault
     * @return \Illuminate\Http\Response
     */
    public function show(OfficeJobDefault $officeJobDefault)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OfficeJobDefault  $officeJobDefault
     * @return \Illuminate\Http\Response
     */
    public function edit(OfficeJobDefault $officeJobDefault)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OfficeJobDefault  $officeJobDefault
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OfficeJobDefault $officeJobDefault)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OfficeJobDefault  $officeJobDefault
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfficeJobDefault $officeJobDefault)
    {
        //
    }
}
