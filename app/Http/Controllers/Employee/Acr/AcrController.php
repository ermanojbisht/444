<?php

namespace App\Http\Controllers\Employee\Acr;

use App\Http\Controllers\Controller;
use App\Http\Requests\Track\StoreEstimateRequest;
use App\Models\Acr\Acr;
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


class AcrController extends Controller
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

    /**
     *   
     * To View All ACR Created by logged in Employee
     */
    public function index()
    {
        $acrs = Acr::where('employee_id', '=', $this->user->employee_id)->get();
        return view('employee.acr.my_acr', compact('acrs'))->with('message', 'error|There was an error...');
    }

    /**
     * @param $id
     * $id => Instance Id
     * To create Estimate
     */
    public function create()
    {
        // abort_if(Gate::denies('track_estimate'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $instanceMovementAndEstimatePermission = 0; //$instance->CheckMovemtPermission($this->user->id);
        // if (!$instanceMovementAndEstimatePermission) {
        //     abort(403);
        // }
        $eeOffices = EeOffice::select(['id', 'name'])->whereIn('div_type', [1, 2])->get();
        return view('employee.acr.create', compact('eeOffices', 'instanceMovementAndEstimatePermission'))
            ->with('success', 'Instance added Successfully !!!');
    }

 
}
