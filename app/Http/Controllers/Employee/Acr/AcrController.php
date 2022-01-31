<?php

namespace App\Http\Controllers\Employee\Acr;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acr\StoreAcrRequest;
use App\Models\Acr\Acr;
use App\Models\Employee;
use App\Traits\AcrFormTrait;
use App\Traits\OfficeTypeTrait; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  

class AcrController extends Controller
{

    use OfficeTypeTrait, AcrFormTrait;

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
        return view('employee.acr.my_acr', compact('acrs'));
    }

    /**
     * @param $id
     * $id => Instance Id
     * To create Estimate
     */
    public function create()
    {  
        $employee = Employee::findOrFail($this->user->employee_id);
        $Officetypes = $this->defineOfficeTypes();
        $acrGroups = $this->defineAcrGroup();
        return view('employee.acr.create', compact('employee','Officetypes','acrGroups'));
    }

    /**
     * @param $request 
     * To Store Indivitual ACR
     */
    public function store(StoreAcrRequest $request)
    { 
        $hrGrievance = Acr::create($request->validated()); 
        return redirect(route('acr.myacrs'));
    }


    public function addOfficers(Acr $acr)
    {
        $appraisalOfficers =  $acr->appraisalOfficers()->get();
        return view('employee.acr.add_officers', compact('acr','appraisalOfficers'));
    }


}
