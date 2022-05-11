<?php

namespace App\Models\HrGrievance;

use App\Models\Employee;
use App\Models\OfficeJob;
use App\Models\OfficeJobDefault;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\OfficeTypeTrait;

class HrGrievance extends Model
{

    use OfficeTypeTrait;

    protected $connection = 'mysqlhrms';
    protected $fillable = [
        'id', 'grievance_type_id', 'description', 'office_type',
        'office_id', 'draft_answer', 'final_answer', 'employee_id', 'refference_grievance_id', 'status_id', 'subject'
    ];

    public function grievanceType()
    {
        return $this->belongsTo(HrGrievanceType::class, "grievance_type_id", "id");
    }

    public function creator()
    {
        return $this->belongsTo(Employee::class, "employee_id", "id");
    }

    public function currentStatus()
    {
        $status = [
            0 => 'Created', 1 => 'Submitted', 2 => 'Draft Answer by L1 Officer',
            3 => 'Final Answer by L2 Officer', 4 => 'Reverted', 5 => 'Reopened'
        ];
        return  $status[$this->status_id];
    }

    public function status_bg_color()
    {
        if ($this->status_id == 0) {
            return 'alert-info   ';
        } else if ($this->status_id == 1) {
            return 'alert-primary    ';
        } else if ($this->status_id == 2) {
            return 'alert-warning   ';
        } else if ($this->status_id == 3) {
            return 'alert-success ';
        } else if ($this->status_id == 4) {
            return 'alert-danger  ';
        } else {
            return 'alert-info ';
        }
    }


    public function office()
    {
        return  $this->OfficeName($this->office_type, $this->office_id);
    }

    /**
     * @return mixed
     */
    public function documents()
    {
        return $this->hasMany(HrGrievanceDocument::class);
    }

    /**
     * @param  $doctitle
     * @return mixed
     */
    public function checkSimlirityOfDocTitle($doctitle)
    {
        $alldoc = $this->documents()->get();

        $new_title = Str::slug($doctitle, '-');
        foreach ($alldoc as $doc) {
            $already_in_record_title = Str::slug($doc->name, '-');
            if ($new_title == $already_in_record_title) {
                return true;
            }
        }
        return false;
    }


    /**
     * @param $jobName
     */
    public function grievanceAssignedToOfficers($jobName)
    {

        $applied_office = $this->office_id;

        $job =  OfficeJob::where('name', $jobName)->get();
        return OfficeJobDefault::where('job_id', $job->id)
        ->where('office_id',$applied_office)->get();

        // $this->user->OfficeToAnyJob(['hr-gr-level-2']);

        // $target_employee_field = config('acr.basic.duty')[$dutyType]['targetemployee'];
        // $target_employee_id = $target_employee_field;
        // if ($target_employee_id) {
        //     return User::where('employee_id', $target_employee_id)->first();
        // }

        return false;
    }


    /**
     * @param $targetDutyType
     * @param $notification_type
     */
    public function mailNotificationFor($targetDutyType, $notification_type, $msg = false)
    {
    }
}
