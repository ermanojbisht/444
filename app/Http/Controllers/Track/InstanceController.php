<?php

namespace App\Http\Controllers\Track;

use App\Http\Controllers\Controller;
use App\Http\Requests\Track\StoreInstanceRequest;
use App\Models\Track\Instance;
use App\Models\Track\InstanceType;
use Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Redirect;

class InstanceController extends Controller
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
            abort_if(Gate::denies('track_estimate'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $this->user = Auth::User();

            return $next($request);
        });
    }

    // my created estimates
    public function index()
    {  // myInstance
        $instances = Instance::estimateType()->where("user_id", $this->user->id)->get();
        $reportTitle = "My Estimates"; 
        $selectedMenu =  "myInstances";
        return view('track.estimate.all_estimates', compact('instances','reportTitle','selectedMenu'))->with('message', 'error|There was an error...'); 
    }

    /**
     * [create new Instance ]
     * @return view for instance creation
     */
    public function create()
    {
        $types = InstanceType::all();

        return view('track.instance.create', compact('types'));
    }

    /**
     * [store description]
     * @param  StoreInstanceRequest $request [description]
     * @return [type]                        [description]
     */
    public function store(StoreInstanceRequest $request)
    {
        $request->merge(['user_id' => $this->user->id]);
        $request->merge(['instance_pending_with_user_id' => $this->user->id]);
        $instance = Instance::create($request->all());
        if ($request->instance_type_id == 1) {
            return Redirect::route('estimate.create', ['id' => $instance->id])->with('success', 'Instance added Successfully !!!');
        }else
        {
            return redirect()->route('myInstances');
        }
    }

    public function destroy(Instance $instance)
    {
       $instance->delete();

    }
}
