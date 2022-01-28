<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfficeJobRequest;
use App\Models\OfficeJob;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OfficeJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('office_job_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $OfficeJobs = OfficeJob::all();

        return view('admin.officeJobs.index', compact('OfficeJobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('office_job_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.officeJobs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfficeJobRequest $request)
    {
         $OfficeJob = OfficeJob::create($request->all());

        return redirect()->route('admin.office-jobs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OfficeJob  $officeJob
     * @return \Illuminate\Http\Response
     */
    public function show(OfficeJob $officeJob)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OfficeJob  $officeJob
     * @return \Illuminate\Http\Response
     */
    public function edit(OfficeJob $officeJob)
    {
        return config('site.in_progress');//"";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OfficeJob  $officeJob
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OfficeJob $officeJob)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OfficeJob  $officeJob
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfficeJob $officeJob)
    {
        //
    }
}
