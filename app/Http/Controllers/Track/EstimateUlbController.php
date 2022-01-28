<?php

namespace App\Http\Controllers\Track;

use App\Http\Controllers\Controller;
use App\Models\Im\Ulb;
use App\Models\Track\InstanceEstimate;
use Illuminate\Http\Request;
use Response;
use Log;
use DB;

class EstimateUlbController extends Controller
{
    public function indexCreateEdit(InstanceEstimate $instanceEstimate)
    {

       $ulbTypes= (new Ulb)->types();

       $ulbs=$instanceEstimate->ulbs()
        ->select('ulbs.id', 'ulbs.title', 'type_id', 'type_name')
        ->get();

        return view('track.estimate.ulb',compact('ulbs','instanceEstimate','ulbTypes'));
    }

    public function store(Request $request)
    {
        Log::info("this = ".print_r($request->all(),true));

        $estimate=InstanceEstimate::findOrFail($request->instance_estimate_id)
       ->ulbs()->syncWithoutDetaching([$request->ulb_id => ['wards' => $request->wards]]);

       return Response::json(['success' => true ], 200);
    }

    public function destroy(Request $request)
    {
        $estimate=InstanceEstimate::findOrFail($request->instance_estimate_id)
       ->ulbs()->detach($request->ulb_id);

       return Response::json(['success' => true ], 200);
    }
}
