<?php

namespace App\Http\Controllers\Employee\Acr;

use App\Http\Controllers\Controller;
use App\Jobs\Acr\SendMailAlertJob;
use App\Models\Acr\Acr;
use App\Models\Employee;
use App\Models\User;
use Log;

class MonitorAcrController extends Controller
{
    public function countEsclation()
    {        
        //reset old data;
        Acr::query()->update([
            'submit_duration_lapsed'=>0,'report_duration_lapsed'=>0,'review_duration_lapsed'=>0,'accept_duration_lapsed'=>0,       
            'timestamps' => false
        ]);
        
        $dutyTypes = ['submit','report', 'review', 'accept']; //what duty is to perform. report means acr is at submit level report is to be done. iska triggerOn submit hoga
        //$dutyTypes =[]; //for debug stop this process and allow identify only
        foreach ($dutyTypes as $key => $dutyType) {
            $duty = config('acr.basic.duty')[$dutyType];
            Log::info("duty.........$dutyType....... = ".print_r($duty,true));
            $acrs = Acr::level($duty['triggerOn'])->select('*')
            //->take(50)
            ->where('acr_type_id','<>',0)
            ->get();

            $acrs->map(function ($acr) use ($dutyType) {
                Log::info("acr id = ".print_r($acr->id,true));
                $acr->updateEsclationFor($dutyType);
            });
        }

        $this->identify();

        /* $acr=Acr::find(15);   return $acr->isScope('level','submit'); */
    }

    /**
     * @return mixed
     */
    public function identify()
    {
        $query = Acr::select('id', 'employee_id', 'report_employee_id', 'review_employee_id', 'accept_employee_id', 'submitted_at', 'report_on', 'review_on', 'accept_on', 'report_duration_lapsed', 'review_duration_lapsed', 'accept_duration_lapsed', 'is_active','acr_type_id')->where(function ($query) {
            $query->where('report_duration_lapsed', '>', 0)
                ->orWhere('review_duration_lapsed', '>', 0)
                ->orWhere('accept_duration_lapsed', '>', 0);
        });

        $query = $query->whereNull('accept_on')->where('is_active', 1)->where('acr_type_id','<>',0);

        $acrs = $query->get();

        $identifiedMailGroups = $acrs->map(function ($acr) {
            //if(in_array($acr->id,[1844,1847,4686,4874])){
                return $acr->analysisForAlert();
            //}
        })->sortBy([
            ['percentage_period', 'desc'],
            ['pending_process', 'asc']
        ])
            ->groupBy('target_employee_id');
        foreach ($identifiedMailGroups as $employee_id => $userPendingAcrs) {
            //if employee is retired then no mail, if mail not verified then no mail
            $employee=Employee::find($employee_id);
            $user=User::where('employee_id',$employee_id)->first();
            if($employee && $user){
                if($employee->isRetired){
                    continue;
                }
                if(!$user->email_verified_at){
                    continue;
                }
                dispatch(new SendMailAlertJob($employee_id, $userPendingAcrs));

            }
        }
    }
}
