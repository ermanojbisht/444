<?php

namespace App\Http\Controllers\Track;

use App\Http\Controllers\Controller;
use App\Http\Requests\Track\StoreUpdateEstimateGroupRequest;
use App\Models\Track\EstimateGroup;
use App\Models\Track\InstanceEstimate;

class EstimateGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instance_estimate_id)
    {
        $instanceEstimate = InstanceEstimate::findOrFail($instance_estimate_id);
        $estimateGroups = EstimateGroup::where('instance_estimate_id', $instance_estimate_id)->get();

        return view('track.estimate.group.index', compact('estimateGroups', 'instanceEstimate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instance_estimate_id)
    {
        $instanceEstimate = InstanceEstimate::findOrFail($instance_estimate_id);

        return view('track.estimate.group.create', compact('instanceEstimate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEstimateGroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store($instance_estimate_id, StoreUpdateEstimateGroupRequest $request)
    {
        EstimateGroup::create($request->all() + ['instance_estimate_id' => $instance_estimate_id]);

        return redirect()->route('instanceEstimate.group.index', $instance_estimate_id);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Track\EstimateGroup $group
     * @return \Illuminate\Http\Response
     */
    public function edit($instance_estimate_id, EstimateGroup $group)
    {
        $instanceEstimate = InstanceEstimate::findOrFail($instance_estimate_id);

        return view('track.estimate.group.edit', compact('instanceEstimate', 'group'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEstimateGroupRequest $request
     * @param  \App\Models\Track\EstimateGroup               $group
     * @return \Illuminate\Http\Response
     */
    public function update($instance_estimate_id, StoreUpdateEstimateGroupRequest $request, EstimateGroup $group)
    {
        $group->update($request->all());

        return redirect()->route('instanceEstimate.group.index', $instance_estimate_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Track\EstimateGroup $group
     * @return \Illuminate\Http\Response
     */
    public function destroy($instanceEstimate, EstimateGroup $group)
    {
        //todo delete group feature
        if($group->features()->count()>0){
            return redirect()->route('instanceEstimate.group.index', $instanceEstimate)->with('fail', 'Can\'t delete this group has feature . First delete those features' );
        }
        $group->delete();

        return redirect()->route('instanceEstimate.group.index', $instanceEstimate)->with('success', 'Sub group deleted' );
    }


}
