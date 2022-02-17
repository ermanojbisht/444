<?php

namespace App\Http\Controllers\Employee\Acr;

use App\Http\Controllers\Controller;
use App\Models\Acr\Acr;
use App\Models\User;
use Illuminate\Http\Request;

class MonitorAcrController extends Controller
{
    public function countEsclation()
    {
        $dutyTypes=['report','review','accept'];  //what duty is to perform. report means acr is at submit level report is to be done. iska triggerOn submit hoga
        foreach ($dutyTypes as $key => $dutyType) {
            $duty=config('acr.basic.duty')[$dutyType];

            $acrs= Acr::level($duty['triggerOn'])->select('*')->get();

            $acrs->map(function($acr) use ($dutyType){
                $acr->updateEsclationFor($dutyType);
            });
        }

       /* $acr=Acr::find(15);   return $acr->isScope('level','submit'); */
    }

    public function identify()
    {
        $query= Acr::select('id','employee_id','report_employee_id','review_employee_id','accept_employee_id','submitted_at','report_on','review_on','accept_on','report_duration_lapsed','review_duration_lapsed','accept_duration_lapsed','is_active')->where(function ($query) {
            $query->where('report_duration_lapsed','>',0)
            ->orWhere('review_duration_lapsed','>',0)
            ->orWhere('accept_duration_lapsed','>',0);
        });

        $query=$query->whereNull('accept_on')->where('is_active',1);

        $acrs= $query->get();

        $identifiedMailGroups=$acrs->map(function($acr) {
            return $acr->analysisForAlert();
        })->sortBy([
            ['percentage_period', 'desc'],
            ['pending_process', 'asc'],
        ])
       ->groupBy('target_employee_id');
       foreach ($identifiedMailGroups as $employee_id => $userPendingAcrs) {
            $targetUser=User::whereEmployeeId($employee_id)->first();
            $previousNotification = AcrNotification::where('employee_id', $employee_id)
                ->where('acr_id', 0)
                ->where('through', 1) //for mail , may be 2 for sms
                ->where('notification_type', 10) //2=for alert
                ->orderBy('notification_on', 'DESC')->first(); //todo search for today        

            if (!$previousNotification) {
                $mail = Mail::to($targetUser);
                $mail->send(new AcrAlertMail($targetUser,$userPendingAcrs));
            }
           
       }
    }
}
