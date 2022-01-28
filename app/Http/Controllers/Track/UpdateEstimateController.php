<?php

namespace App\Http\Controllers\Track;

use App\Http\Controllers\Controller;
use App\Http\Requests\Track\UpdateEstimateDetailsRequest;
use App\Http\Requests\Track\UpdateEstimateRequest;
use App\Models\Block;
use App\Models\Constituency;
use App\Models\District;
use App\Models\EeOffice;
use App\Models\Loksabha;
use App\Models\Track\Instance;
use App\Models\Track\InstanceEstimate;
use App\Models\WorkType;
use Gate;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Redirect;
use Symfony\Component\HttpFoundation\Response;

class UpdateEstimateController extends Controller
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
            //abort_if(Gate::denies('track_estimate'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $this->user = Auth::User();

            return $next($request);
        });
    }


    /**
     * @param $id
     * $id => Instance Id
     * To create Estimate
     */
    public function editEstimate($estimateId)
    {
        abort_if(Gate::denies('track_estimate'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $estimate = InstanceEstimate::findOrFail($estimateId);

        $instanceMovementAndEstimatePermission = $estimate->instance->CheckMovemtPermission($this->user->id);
        if (!$instanceMovementAndEstimatePermission) {
            abort(403);
        }
        $instance =  $estimate->instance;
        $isEditable=Helper::checkBackDate($estimate->created_at,false,'estimateEdit');

        $districts = District::all();
        $workType = WorkType::all();
        $Loksabhas = Loksabha::all();
        $eeOffices = EeOffice::select(['id', 'name'])->whereIn('div_type', [1, 2])->get();

        $all_district_blocks = Block::where("district_id", $estimate->district_id)->get()->pluck('name', 'id');
        $instance_blocks =  $estimate->allblocks()->get()->pluck('name', 'id');
        $all_district_constituencies = Constituency::where("district_id", $estimate->district_id)->get()->pluck('name', 'id');
        $instance_constituencies = $estimate->constituencies()->get()->pluck('name', 'id');

        $reportTitle = "Edit Details";

        return view('track.estimate.updateEstimate', compact(
            'instance',
            'isEditable',
            'all_district_blocks',
            'instance_blocks',
            'all_district_constituencies',
            'instance_constituencies',
            'eeOffices',
            'estimate',
            'districts',
            'Loksabhas',
            'workType',
            'reportTitle',
            'instanceMovementAndEstimatePermission'
        ))->with('success', 'Instance added Successfully !!!');
    }

    /**
     * @param Request $request
     */
    public function updateEstimate(UpdateEstimateRequest $request) // UpdateEstimateRequest
    {

        $blockArray = $request->block_id;
        $consituencyArray = $request->constituency_id;
        $block_id = (count($request->block_id) < 2) ? $request->block_id[0] : 0;
        $constituency_id = (count($request->constituency_id) < 2) ? $request->constituency_id[0] : 0;

        $request->merge(['block_id' => $block_id]);
        $request->merge(['constituency_id' => $constituency_id]);

        $instance = Instance::findOrFail($request->instance_id);
        $instance->update(['instance_name' => $request->instance_Name]);


        $instanceEstimate = InstanceEstimate::find($instance->estimate->id);
        $instanceEstimate->timestamps = false;

        $instanceEstimate->update($request->all());

        $instanceEstimate->save();

        $instanceEstimate->allblocks()->sync($blockArray);
        $instanceEstimate->constituencies()->sync($consituencyArray);

        return Redirect::route("myInstances");
    }

    /**
     * @param $id
     * For Adding Details of Estimate
     */
    public function editEstimateDetails(InstanceEstimate $instanceEstimate) // 
    {

        $instanceMovementAndEstimatePermission = $instanceEstimate->instance->CheckMovemtPermission($this->user->id);
        if (!$instanceMovementAndEstimatePermission) {
            abort(403);
        }

        $instance =  $instanceEstimate->instance;


        $isEditable = Helper::checkBackDate($instanceEstimate->created_at, false, 'estimateEdit');
        $instance_blocks =  $instanceEstimate->allblocks()->get()->pluck('name', 'id');
        $instance_constituencies =  $instanceEstimate->constituencies()->get()->pluck('name', 'id');

        $reportTitle = "Edit Details";

        return view('track.estimate.updateEstimateDetails', compact('isEditable', 'instance', 'instanceEstimate', 'instance_blocks', 'instance_constituencies', 'reportTitle', 'instanceMovementAndEstimatePermission'))
            ->with('status', 'Instance added Successfully !!!');
    }

    /**
     * @param Request $request
     */
    public function updateEstimateDetails(UpdateEstimateDetailsRequest $request) // AddEstimateDetailsRequest
    {
        $instance_Estimate_id = $request->instance_Estimate_id;
        $instanceEstimate = InstanceEstimate::find($instance_Estimate_id);
        $instanceEstimate->update($request->all());
        $instanceEstimate->save();
        return Redirect::route('movement', ['instanceId' => $instanceEstimate->instance_id, 'senderId' => $this->user->id])->with('status', 'Instance added Successfully !!!');
    }
}
