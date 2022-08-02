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
use Log;

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
            return ["other_offices",$this->other_office_id];

        if ($this->head_quarter > 0)
            return ["office_head_quarters",$this->head_quarter];

        if ($this->office_id > 0)
            return ["mispwd.offices",$this->office_id];

        return false;
    }

    public function saveSugamDurgamPeriod()
    {
        //Log::info("posting = ".print_r($this->toArray(),true));
        $postingOfficeTableAndFields=$this->getTableName();
        if ($postingOfficeTableAndFields) {

             $postingOffices = OfficeSugamDurgam::where("table_name", $postingOfficeTableAndFields[0])
                ->where("office_id", $postingOfficeTableAndFields[1])->orderBy('start_date')->get();

            if ($postingOffices) {
                $fromPostingDate = $this->from_date;
                $toPostingDate = $this->to_date?$this->to_date:Helper::lastDateForTransferCOnsideration();
                $countedSDays = $countedDDays = 0;
                foreach ($postingOffices as $postingOffice) {
                    //Log::info("postingOffice = ".print_r($postingOffice->toArray(),true));
                    $postingOffice->end_date = (!$postingOffice->end_date) ? Carbon::today() : $postingOffice->end_date;
                    //Log::info("fromPostingDate = ".print_r($fromPostingDate->format('Y-m-d'),true));
                    //Log::info("toPostingDate = ".print_r($toPostingDate->format('Y-m-d'),true));
                    //Log::info("postingOffice->start_date = ".print_r($postingOffice->start_date->format('Y-m-d'),true));
                    //Log::info("postingOffice->end_date = ".print_r($postingOffice->end_date->format('Y-m-d'),true));
                    $countedDays = 0;

                    if($fromPostingDate->gt($postingOffice->end_date))
                        continue;

                    //Log::info("fromPostingDate->gt(postingOffice->end_date  is false");
                    if ($toPostingDate <= $postingOffice->end_date) {
                        //Log::info("toPostingDate <= postingOffice->end_date ");
                        $countedDays = ($toPostingDate->diffInDays($fromPostingDate) + 1) * $postingOffice->duration_factor;
                        if ($postingOffice->isdurgam) {
                            $countedDDays = $countedDDays + $countedDays;
                        } else {
                            $countedSDays = $countedSDays + $countedDays; 
                        }
                        break;
                    } else {
                        //Log::info("toPostingDate >...... postingOffice->end_date ");
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
