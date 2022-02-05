<?php

namespace App\Http\Controllers\Employee\OthersAcr;

use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth;  

class AcrReviewController extends Controller
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


}
