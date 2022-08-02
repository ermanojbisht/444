<?php

namespace App\Models\Hrms;

use App\Helpers\Helper;
use App\Models\Designation;
use App\Models\Hrms\Employee;
use App\Models\Office;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posting extends Model
{
    use HasFactory;

    public $table = 'postings';
    protected $dates = ['from_date', 'to_date', 'order_at', 'created_at', 'updated_at'];
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'employee_id', 'order_no', 'order_at', 'office_id', 'other_office_id', 'head_quarter_id', 'from_date', 'to_date', 'mode_id', 'designation_id', 'is_prabhari', 'is_locked', 's_d', 'd_d', 'attached_posting_id', 'created_at', 'updated_at'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function otherOffice()
    {
        return $this->belongsTo(OtherOffice::class);
    }

    public function headQuarter()
    {
        return $this->belongsTo(OfficeHeadQuarter::class);
    }

    public function postingOffice()
    {
        if ($this->other_office_id)
            return $this->otherOffice();
        if ($this->head_quarter_id)
            return $this->headQuarter();
        if ($this->office_id)
            return $this->office();
    }

    public function getTableName()
    {
        if ($this->other_office_id >  0)
            return "other_offices";

        if ($this->head_quarter > 0)
            return "office_head_quarters";

        if ($this->office_id > 0)
            return "mispwd.offices";

        return false;
    }

    public function saveSugamDurgamPeriod()
    {
        if ($this->getTableName()) {
             $postingOffices = OfficeSugamDurgam::where("table_name", $this->getTableName())
                ->where("office_id", $this->office_id)->orderBy('start_date')->get();

            if ($postingOffices) {
                $fromPostingDate = $this->from_date;
                $toPostingDate = $this->to_date;
                $countedSDays = $countedDDays = 0;
                foreach ($postingOffices as $postingOffice) {
                    $postingOffice->end_date = (!$postingOffice->end_date) ? Carbon::today() : $postingOffice->end_date;
                    $countedDays = 0;

                    if($fromPostingDate > $postingOffice->end_date)
                        continue;

                    if ($toPostingDate <= $postingOffice->end_date) {
                    $countedDays = ($toPostingDate->diffInDays($fromPostingDate) + 1) * $postingOffice->duration_factor;
                        if ($postingOffice->isdurgam) {
                            $countedDDays = $countedDDays + $countedDays;
                        } else {
                            $countedSDays = $countedSDays + $countedDays; 
                        }
                        break;
                    } else {
                     $countedDays = ($postingOffice->end_date->diffInDays($fromPostingDate) + 1) * $postingOffice->duration_factor;
                        if ($postingOffice->isdurgam) {
                            $countedDDays = $countedDDays + $countedDays; 
                        } else {
                            $countedSDays = $countedSDays + $countedDays; 
                        }
                        $fromPostingDate = $postingOffice->end_date->addDay();
                    }
                }

                $this->update([
                    's_d' => $countedSDays,
                    'd_d' => $countedDDays,
                ]);
            } //postingOffices
        }
    }


    


}
