<?php

namespace App\Models\HrGrievance;

use App\Models\Employee;
use App\Models\OfficeJob;
use App\Models\OfficeJobDefault;
use App\Notifications\Grievance\GrSubmittedNotification;
use App\Traits\OfficeTypeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Log;

class HrGrievance extends Model
{

    use OfficeTypeTrait;

    protected $connection = 'mysqlhrms';
    protected $fillable = [
        'id', 'grievance_type_id', 'description', 'office_type',
        'office_id', 'draft_answer', 'final_answer', 'employee_id', 'refference_grievance_id',
        'status_id', 'subject'
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
            0 => 'Created',
            1 => 'Submitted',
            2 => 'Draft Answer by L1 Officer',
            3 => 'Final Answer by L2 Officer',
            4 => 'Reverted',
            5 => 'Reopened'
        ];
        return  $status[$this->status_id]  . ' on  ' . $this->updated_at->format('d M Y');
    }

    public function resolver($resolverType)
    {
        if ($resolverType == 'final') {
            $OfficeJobDefault = OfficeJobDefault::where('job_id', 2)->where('office_id', $this->office_id)->first();
        } else {
            $OfficeJobDefault = OfficeJobDefault::where('job_id', 1)->where('office_id', $this->office_id)->first();
        }  // ($resolverType == 'draft') 

        if ($OfficeJobDefault) {
            return $OfficeJobDefault->user;
        }
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
    public function userFor($jobName)
    {
        $job =  OfficeJob::where('name', $jobName)->first();
        if ($job) {
            $OfficeJobDefault = OfficeJobDefault::where('job_id', $job->id)->where('office_id', $this->office_id)->first();
            if ($OfficeJobDefault) {
                return $OfficeJobDefault->user;
            }
        }
        return false;
    }


    /**
     * @param $targetDutyType
     * @param $notification_type
     */
    public function notificationFor($milestone)
    {
        switch ($milestone) {
            case 'submit':
            case 'revert':
                $user = $this->userFor('hr-gr-draft');
                break;
            case 'draft':
                $user = $this->userFor('hr-gr-final');
                break;
            case 'final':
                $user = $this->creator;
                break;
        }
        if ($user) {
            $user->notify(new GrSubmittedNotification($this, $milestone));
        }
    }
}
