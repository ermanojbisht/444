<?php

namespace App\Http\Controllers\Employee\Acr;

use App\Http\Controllers\Controller;
use App\Models\Acr\Acr;
use Illuminate\Http\Request;

class MonitorAcrController extends Controller
{
    public function countEsclation()
    {
        $dutyTypes=['report','review','accept'];
        foreach ($dutyTypes as $key => $dutyType) {
            $duty=config('acr.basic.duty')[$dutyType];

            $acrs= Acr::level($duty['triggerOn'])->select('*')->get();

            $acrs->map(function($acr) use ($dutyType){
                $acr->updateEsclationFor($dutyType);
            });
        }

       /* $acr=Acr::find(15);   return $acr->isScope('level','submit'); */
    }
}
