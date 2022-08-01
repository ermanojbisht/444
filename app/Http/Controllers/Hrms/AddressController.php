<?php

namespace App\Http\Controllers\Hrms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\Hrms\StoreAddressRequest;
use App\Http\Requests\Employee\Hrms\StoreEmployeeRequest;
use App\Http\Requests\Employee\Hrms\UpdateEmployeeRequest;
use App\Models\Hrms\Address;
use App\Models\Hrms\Constituency;
use App\Models\Hrms\District;
use App\Models\Hrms\Employee;
use App\Models\Hrms\State;
use App\Models\Tehsil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Redirect; 

class AddressController extends Controller
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
            $this->user = Auth::User();
            return $next($request);
        });
    }

    /**
     ** Add Address Details
     * [view Employee Add Address ] by Office 
     * @return view for Employee Add Address 
     */
    public function create(Employee $employee)
    {
        $states = array('' => 'Select State') + State::orderBy('id')->pluck('name', 'id')->toArray();
        $districts = array('' => 'Select District') + District::orderBy('id')->pluck('name', 'id')->toArray();
        $tehsils = array('' => 'Select Tehsil') + Tehsil::orderBy('name')->pluck('name', 'id')->toArray();
        $constituencies = array('' => 'Select VidhanSabha') + Constituency::orderBy('name')
        ->pluck('name', 'id')->toArray();


        return view('hrms.employee.Address.create', compact('employee', 'states', 
            'districts', 'tehsils', 'constituencies'));
    }


    /**
     ** Add Address Details
     * [view Employee Add Address ] by Office 
     * @return view for Employee Add Address 
     */
    public function store(StoreAddressRequest $request)
    {        

        $address = Address::create($request->validated());

        $address->employee->updateHomeDetails();
           
        return redirect()->route('employee.createAddress',['employee'=>$request->employee_id])
        ->with('status', 'Address Updated Successfully!'); 
    }
    
    public function edit($addressType, Employee $employee)
    {
        $address = $employee->getAddress($addressType);

        $states = array('' => 'Select State') + State::orderBy('id')->pluck('name', 'id')->toArray();
        $districts = array('' => 'Select District') + District::orderBy('id')->pluck('name', 'id')->toArray();
        $tehsils = array('' => 'Select Tehsil') + Tehsil::orderBy('name')->pluck('name', 'id')->toArray();
        $constituencies = array('' => 'Select VidhanSabha') + Constituency::orderBy('name')
        ->pluck('name', 'id')->toArray();

        return view('hrms.employee.Address.edit', compact('address','addressType', 'employee', 
        'states', 'districts', 'tehsils', 'constituencies'));
    }

    
    public function update(StoreAddressRequest $request)
    {

        
       $address->employee->updateHomeDetails();


    }

    



}
