<?php

namespace App\Http\Controllers\Track;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Im\Village;
use App\Models\Track\InstanceEstimate;
use Illuminate\Http\Request;
use Response;
use Log;

class EstimateVillageController extends Controller
{
    public function indexCreateEdit(InstanceEstimate $instanceEstimate)
    {

       $villages=$instanceEstimate->villages()
        ->select( 'villages.id', 'villages.name', 'villages.Tot_p')
        ->get();

        $blocks=Block::all()->sortBy('name')->pluck('name','id');
        return view('track.estimate.village',compact('villages','instanceEstimate','blocks'));
    }

    public function store(Request $request)
    {
        $estimate=InstanceEstimate::findOrFail($request->instance_estimate_id)
       ->villages()->syncWithoutDetaching($request->village_id);

       return Response::json(['success' => true ], 200);
    }

    public function destroy(Request $request)
    {

        $estimate=InstanceEstimate::findOrFail($request->instance_estimate_id)
       ->villages()->detach($request->village_id);

       return Response::json(['success' => true ], 200);
    }
}
