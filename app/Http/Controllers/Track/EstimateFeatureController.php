<?php

namespace App\Http\Controllers\Track;

use App\Http\Controllers\Controller;
use App\Http\Requests\Track\StoreEstimateFeatureRequest;
use App\Http\Requests\Track\UpdateEstimateFeatureRequest;
use App\Models\Track\EstimateFeature;
use App\Models\Track\EstimateFeatureGroup;
use App\Models\Track\EstimateFeatureType;
use App\Models\Track\InstanceEstimate;
use Log;

class EstimateFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instance_estimate_id)
    {
        $instanceEstimate=InstanceEstimate::findOrFail($instance_estimate_id);
        $estimateFeatures = EstimateFeature::where('instance_estimate_id', $instance_estimate_id)->get();
        return view('track.estimate.feature.index', compact('estimateFeatures', 'instanceEstimate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instance_estimate_id)
    {
        $instanceEstimate=InstanceEstimate::findOrFail($instance_estimate_id);
        $estimateFeatureTypes=EstimateFeatureType::all();
        $estimateFeatureGroups=EstimateFeatureGroup::all();
        $estimateGroups=$instanceEstimate->modifiedEstimateGroupCollection();
        $lastAddedFeatureGroup=$instanceEstimate->lastAddedFeatureGroup();
        $lastAddedGroup=$instanceEstimate->lastAddedGroup();
        return view('track.estimate.feature.create', compact('instanceEstimate','estimateFeatureGroups','estimateFeatureTypes','lastAddedFeatureGroup','estimateGroups','lastAddedGroup'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEstimateFeatureRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($instance_estimate_id,StoreEstimateFeatureRequest $request)
    {
        EstimateFeature::create($request->all() + ['instance_estimate_id' => $instance_estimate_id]);
        return redirect()->route('instanceEstimate.instanceEstimateFeature.index', $instance_estimate_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Track\EstimateFeature  $estimateFeature
     * @return \Illuminate\Http\Response
     */
    public function edit($instance_estimate_id,EstimateFeature $instanceEstimateFeature)
    {
        $instanceEstimate=InstanceEstimate::findOrFail($instance_estimate_id);
        $estimateFeatureTypes=EstimateFeatureType::all();
        $estimateFeatureGroups=EstimateFeatureGroup::all();
        $estimateGroups=$instanceEstimate->modifiedEstimateGroupCollection();
        $lastAddedFeatureGroup=$instanceEstimateFeature->type->group_id;
        $lastAddedGroup=$instanceEstimate->lastAddedGroup();
        return view('track.estimate.feature.edit', compact('instanceEstimate', 'instanceEstimateFeature','estimateFeatureTypes','estimateFeatureGroups','lastAddedFeatureGroup','estimateGroups','lastAddedGroup'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEstimateFeatureRequest  $request
     * @param  \App\Models\Track\EstimateFeature  $estimateFeature
     * @return \Illuminate\Http\Response
     */
    public function update($instance_estimate_id,StoreEstimateFeatureRequest $request, EstimateFeature $instanceEstimateFeature)
    {
        $instanceEstimateFeature->update($request->all());
        return redirect()->route('instanceEstimate.instanceEstimateFeature.index', $instance_estimate_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Track\EstimateFeature  $estimateFeature
     * @return \Illuminate\Http\Response
     */
    public function destroy($instanceEstimate,EstimateFeature $instanceEstimateFeature)
    {
         $instanceEstimateFeature->delete();
        return redirect()->route('instanceEstimate.instanceEstimateFeature.index', $instanceEstimate);

    }
}
