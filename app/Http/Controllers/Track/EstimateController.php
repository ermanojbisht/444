<?php

namespace App\Http\Controllers\Track;

use App\Http\Controllers\Controller;
use App\Http\Requests\Track\StoreEstimateRequest;
use App\Models\Block;
use App\Models\Constituency;
use App\Models\Designation;
use App\Models\District;
use App\Models\EeOffice;
use App\Models\Employee;
use App\Models\Loksabha;
use App\Models\Track\Instance;
use App\Models\Track\InstanceEstimate;
use App\Models\Track\InstanceHistory;
use App\Models\Track\MInstanceStatus;
use App\Models\User;
use App\Models\WorkType;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Redirect;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;
use Helper;


class EstimateController extends Controller
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
            // abort_if(Gate::denies('track_estimate'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $this->user = Auth::User();

            return $next($request);
        });
    }


    public function index()
    {
        $instances = Instance::estimateType()->get();
        $reportTitle = "All Estimates";
        $selectedMenu =  "allEstimateList";

        return view('track.estimate.all_estimates', compact('instances','reportTitle','selectedMenu'))->with('message', 'error|There was an error...');
    }

    /**
     * @param $id
     * $id => Instance Id
     * To create Estimate
     */
    public function create($id)
    {
        abort_if(Gate::denies('track_estimate'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $instance = Instance::findOrFail($id);
        $instanceMovementAndEstimatePermission = $instance->CheckMovemtPermission($this->user->id);
        if (!$instanceMovementAndEstimatePermission) {
            abort(403);
        }
        $districts = District::all();
        $workType = WorkType::all();
        $Loksabhas = Loksabha::all();
        $eeOffices = EeOffice::select(['id', 'name'])->whereIn('div_type', [1, 2])->get();
        return view('track.estimate.create', compact(
            'eeOffices',
            'instance',
            'districts',
            'Loksabhas',
            'workType',
            'instanceMovementAndEstimatePermission'
        ))
            ->with('success', 'Instance added Successfully !!!');
    }


    /**
     * @param Request $request
     */
    public function store(StoreEstimateRequest $request)
    {
        $blockArray = $request->block_id;
        $consituencyArray = $request->constituency_id;
        $block_id = (count($request->block_id) < 2) ? $request->block_id[0] : 0;
        $constituency_id = (count($request->constituency_id) < 2) ? $request->constituency_id[0] : 0;

        $request->merge(['block_id' => $block_id]);
        $request->merge(['constituency_id' => $constituency_id]);

        $instanceEstimate = InstanceEstimate::create($request->all());

        $instanceEstimate->allblocks()->sync($blockArray);
        $instanceEstimate->constituencies()->sync($consituencyArray);
        return Redirect::route('myInstances');
    }


    // for Inbox
    public function receivedInstances()
    {
        $instances = Instance::whereIn('id', InstanceHistory::where("to_id", $this->user->id)->where("action_taken", "0")->pluck('instance_id'))
            ->orWhere("instance_pending_with_user_id", $this->user->id)->get();
        $reportTitle = "Received Estimates";
        $selectedMenu = "receivedInstances";



        return view('track.estimate.all_estimates', compact('instances', 'reportTitle', 'selectedMenu'));
    }


    // for Sent Items
    public function sentEstimateInstances()
    {
        $instances = Instance::whereIn('id', InstanceHistory::where("from_id", $this->user->id)->where("action_taken", "0")->pluck('instance_id'))
            ->orWhere("instance_pending_with_user_id", $this->user->id)->get();
        $reportTitle = "Sent Estimates";
        $selectedMenu =  "sentInstances";
        return view('track.estimate.all_estimates', compact('instances', 'reportTitle', 'selectedMenu'));
    }





    /**
     * @param $id
     * view instance
     */
    public function show(InstanceEstimate $instanceEstimate)
    {
        $instance = Instance::findOrFail($instanceEstimate->instance_id);

        $instanceMovementAndEstimatePermission = $instance->CheckMovemtPermission($this->user->id);

        if ($instanceEstimate) {
            $instance_blocks = $instanceEstimate->allblocks()->get()->pluck('name', 'id');
            $instance_constituencies = $instanceEstimate->constituencies()->get()->pluck('name', 'id');
        } else {
            $instance_blocks = $instance_constituencies =  [];
        }
        $instanceHistory = $instance->history;
        if ($instanceHistory) {
            $receivers = $this->getReceivers($instanceHistory);
            $remarks = $this->getRemarks($instanceHistory);
        }

        $images = $instanceEstimate->pics()->get();

        return view('track.estimate.view', compact('instance', 'instanceEstimate', 'receivers', 'remarks', 'instance_blocks', 'instance_constituencies','instanceMovementAndEstimatePermission','images'));
    }

    public function ajaxDataForEstimateMovements(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->instanceId;
            $query = InstanceHistory::with(['sender', 'receiver'])->where("instance_id", "$id");  //$query = Instance::find($id)->with(['history' ]);
            $table = Datatables::of($query);
            return $table->make(true);
        }
    }

    /**
     * @param $id
     * @param $sender_id
     * show view for movement
     */
    public function moveEstimates($instanceId, $sender_id)
    {
        $instance = Instance::findOrFail($instanceId);
       
       $instanceMovementAndEstimatePermission = $instance->CheckMovemtPermission($this->user->id);
        if (!$instanceMovementAndEstimatePermission){   
            abort(403);
        }
 
        $instanceEstimate = $instance->estimate;
        $history = $instance->history()->get();
        if ($history->count() > 0) {
            $userWhoHasInstance = $history->where('action_taken', 0)->pluck('to_id');
            $senderList = User::whereIn('id', $userWhoHasInstance)->orWhere('id', $this->user->id)->get();
            //$recipentList = User::where("user_type", "1")->where('id', '<>', $this->user->id)->whereNotIn('id', $userWhoHasInstance)->get();
        } else {
            $senderList = User::where("user_type", "1")->get();
            //$recipentList = User::where("user_type", "1")->where('id', '<>', $this->user->id)->get();
        }

        $recipentList = User::where("user_type", "1")->where('id', '<>', $this->user->id)->get();
        
        $statusses = MInstanceStatus::all();

        $instance_blocks = $instanceEstimate->allblocks()->get()->pluck('name', 'id');

        $instance_constituencies = $instanceEstimate->constituencies()->get()->pluck('name', 'id');
        $sender = $sender_id;
        $employees = Employee::whereNotIn('id', User::get('emp_code'))->where("designation_id", "20")->get();    //20 designation is AE 
        $designations = Designation::where("is_active", "1")->get();
        $instance_history = InstanceHistory::where("instance_id", $instanceId)->get();
        return view('track.estimate.movement', compact(
            'statusses',
            'instance_blocks',
            'instanceEstimate',
            'instance_constituencies',
            'sender',
            'instance',
            'employees',
            'designations',
            'recipentList',
            'senderList',
            'instance_history',
            'instanceMovementAndEstimatePermission'
        ));
    }

    /**
     * @param Request $request
     */
    public function storeEstimateMovements(Request $request)
    {

        if ($request->registredUsers && in_array($request->sender_id, $request->registredUsers)) {
            return redirect()->back()->with('fail', "Sender and reciver can not be the same person.");
        }

        InstanceHistory::where("to_id", $request->sender_id)->where("instance_id", $request->instance_id)
            ->where("action_taken", "0")->update(['action_taken' => 1]);

        if ($request->registredUsers) {
            foreach ($request->registredUsers as $user) {
                $userInfo = User::where("id", $user)->get();
                $receivers_data = new InstanceHistory();

                $receivers_data->instance_id = $request->instance_id;
                $receivers_data->from_id = $request->sender_id;
                $receivers_data->to_id = $userInfo[0]->id;

                $receivers_data->emp_code = $userInfo[0]->emp_code;
                $receivers_data->emp_name = $userInfo[0]->name;
                $receivers_data->designation = $userInfo[0]->designation;
                $receivers_data->office = null;
                $receivers_data->remarks = $request->remarks;
                $receivers_data->action_taken = "0";
                $receivers_data->isViewed = false;
                $receivers_data->save();
            }
        }

        if ($request->employees) {
            foreach ($request->employees as $emp_code) {
                $employee = Employee::where("id", $emp_code)->first();
                $receivers_data = new InstanceHistory();
                $receivers_data->instance_id = $request->instance_id;
                $receivers_data->from_id = $request->sender_id;

                $receivers_data->emp_code = $employee->id;
                $receivers_data->emp_name = $employee->name;
                $receivers_data->designation = $employee->designation->name;

                $receivers_data->remarks = $request->remarks;
                $receivers_data->action_taken = "0";

                $receivers_data->save();
            }
        }

        if (null != $request->emp_name) {
            $receivers_data = new InstanceHistory();
            $receivers_data->instance_id = $request->instance_id;
            $receivers_data->from_id = $request->sender_id;
            $receivers_data->to_id = null;
            $receivers_data->emp_code = null;
            $receivers_data->emp_code = null;
            $receivers_data->emp_name = $request->emp_name;
            $receivers_data->designation = $request->emp_designation;
            $receivers_data->office = $request->office_name;
            $receivers_data->remarks = $request->remarks;
            $receivers_data->action_taken = "0";
            $receivers_data->isViewed = false;

            $receivers_data->save();
        }

        $instance = Instance::find($request->instance_id);
        $instance->updateFirstMovementStatus();
        $instance->savePendingWithRecognizeUser();

        return Redirect::route('receivedInstances');
    }

    /**
     * @param $id
     * @param $sender_id
     * show update Estimate Status  updateEstimateStatus
     */
    public function editEstimateStatus($instance_id)
    {
        $instance = Instance::findOrFail($instance_id);
        $instanceMovementAndEstimatePermission = $instance->CheckMovemtPermission($this->user->id);
        if (!$instanceMovementAndEstimatePermission) {
            abort(403);
        }
        $instanceEstimate = $instance->estimate;
        $history = $instance->history()->get();
        if ($history->count() > 0) {
            $userWhoHasInstance = $history->where('action_taken', 0)->pluck('to_id');
            $recipentList = User::where("user_type", "1")->where('id', '<>', $this->user->id)->whereNotIn('id', $userWhoHasInstance)->get();
        } else {

            $recipentList = User::where("user_type", "1")->where('id', '<>', $this->user->id)->get();
        }
        $statusses = MInstanceStatus::all();
        $instance_blocks = $instanceEstimate->allblocks()->get()->pluck('name', 'id');
        $instance_constituencies = $instanceEstimate->constituencies()->get()->pluck('name', 'id');
        $employees = Employee::whereNotIn('id', User::get('emp_code'))->where("designation_id", "20")->get();
        //20 designation is AE        
        $designations = Designation::where("is_active", "1")->get();
        $instance_history = InstanceHistory::where("instance_id", $instance_id)->get();
        return view('track.estimate.update_estimate_status', compact(
            'statusses',
            'instance_blocks',
            'instanceEstimate',
            'instance_constituencies',
            'instance',
            'employees',
            'designations',
            'recipentList',
            'instance_history',
            'instanceMovementAndEstimatePermission'
        ));
    }


    /**
     * @param Request $request
     */
    public function updateEstimateStatus(Request $request)
    {
        $instance = Instance::find($request->instance_id);
        $instance->status_master_id = $request->status_master_id;  // // $instance->update(['status_master_id' => $request->status_master_id]);
        $instance->save();
        return Redirect::route('receivedInstances');
    }



    /**
     * @param Request $request
     * @return mixed
     */
    public function getBlocksInDistrict(Request $request)
    {
        $district = $request->get('district');
        $qry = Block::where("district_id", $district)->select("id", "name")->get();

        return $qry;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getConstituenciesInDistrict(Request $request)
    {
        $district = $request->get('district');
        $qry = Constituency::where("district_id", $district)->select("id", "name")->get();

        return $qry;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getLoksabhaByconstituency(Request $request)
    {
        $selectedConstituency = $request->get('constituency');
        $loksabha = Constituency::where("id", $selectedConstituency)->Loksabha();

        return $loksabha;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getEmployeeDesignationWise(Request $request)
    {
        $selectedDesignation = $request->get('designation');
        $employees = Employee::whereNotIn('id', User::get('emp_code'))->where("designation_id", $selectedDesignation)->get();

        return $employees;
    }

    public function getReceivers($history)
    {
        $receiversData = [];
        foreach ($history as $receiver) {
            if (!$receiver->to_id) {
                if (!$receiver->emp_code) {
                    $receiversData[] = [
                        'key' => 99999,
                        'text' => $receiver->emp_name . " (" . $receiver->designation . ")",
                    ];
                }
            } else {
                if (!in_array($receiver->from_id, array_column($receiversData, 'key'))) {
                    $receiversData[] = [
                        'key' => $receiver->from_id,
                        'text' => $receiver->sender->name . " (" . $receiver->sender->designation . ")",
                    ];
                }

                if (!in_array($receiver->to_id, array_column($receiversData, 'key'))) {
                    $receiversData[] = [
                        'key' => $receiver->to_id,
                        'text' => $receiver->receiver->name . " (" . $receiver->receiver->designation . ")",
                    ];
                }
            }
        }
        return json_encode($receiversData);
    }

    public function getRemarks($history)
    {
        $receiversRemarks = [];
        foreach ($history as $receiver) {
            // $tshape = ($tshape == 2) ? 1 : 2;
            $sent_to = 0;
            if (null == $receiver->to_id) {
                $sent_to = 99999;
            } else {
                $sent_to = $receiver->to_id;
            }

            $receiversRemarks[] = [
                'from' => $receiver->from_id,
                'to' => $sent_to,
                'text' => $receiver->remarks,
                //'patt' => 'Tshape' . $tshape,
                'inStatus' => 'Blue',
            ];
        }

        return json_encode($receiversRemarks);
    }
}
