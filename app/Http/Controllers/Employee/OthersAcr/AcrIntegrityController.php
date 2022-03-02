<?php

namespace App\Http\Controllers\Employee\OthersAcr;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acr\StoreAcrRequest;
use App\Models\Acr\Acr;
use App\Models\Acr\AcrRejection;
use App\Models\Employee;
use App\Traits\Acr\AcrFormTrait;
use App\Traits\OfficeTypeTrait;
use Carbon\Carbon;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcrIntegrityController extends Controller
{

    use OfficeTypeTrait, AcrFormTrait;

    /**
     * @var mixed
     */
    protected $user;
    protected $msg403 = 'Unauthorized action.You are not authorised to see this ACR details';

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

   
    public function viewIntegrity(Acr $acr)
    {
        abort_if($this->user->employee_id <> $acr->report_employee_id, 403, $this->msg403);        
        return view('employee.other_acr.view_reported_acr', compact('acr'));
    }


 
}
