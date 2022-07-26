<?php

namespace App\Models\Hrms;

use App\Helpers\Helper;
use App\Models\Designation;
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
        'id',
        'employee_id',
        'order_no',
        'order_at',
        'office_id',
        'other_office_id',
        'head_quarter',
        'from_date',
        'to_date',
        'mode_id',
        'designation_id',
        'regular_incharge',
        'islocked',
        'row_confirm',
        'days_in_office',
        'created_at',
        'updated_at'
    ];

    // public function state(){
    //     return $this->belongsTo(state::class);
    // }

    public function officeName()
    {
        return $this->belongsTo(Office::class, "office_id", "id");
    }

    public function designationName()
    {
        return $this->belongsTo(Designation::class, "designation_id", "id");
    }

    public function otherOfficeName($id)
    {
        return OtherOffice::find($id)->name;
    }

    public function headOfficeName($id)
    {
        return OfficeHeadQuarter::find($id)->name;
    }


    public function getPosting_is_Sugam_and_Duration($office_type, $office_id)
    {
        if ($office_type == 3)
            $currentOffice = OfficeHeadQuarter::where("id", $office_id)->first();

        if ($office_type == 2)
            $currentOffice = OtherOffice::where("id", $office_id)->first();

        if ($office_type == 1)
            $currentOffice = Office::where("id", $office_id)->first();

        if ($currentOffice) {
            if ($currentOffice->isdurgam)
                return "Durgam <br/> (F=" . $currentOffice->duration_factor . ")";
            else
                return "Sugam <br/> (F=" . $currentOffice->duration_factor . ")";
        }
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

    public function set_durgam_sugam()
    {
        $office_type_identifier_table_name  = $this->getTableName();

        if ($office_type_identifier_table_name) {
            $posted_offices_durgam_sugam_period = OfficeSugamDurgam::where("table_name", $office_type_identifier_table_name)
                ->where("office_id", $this->office_id)->get();

            $duration_factor = 1.00;

            foreach ($posted_offices_durgam_sugam_period as $posted_office) {

                // $this->update([
                // 'days_in_office' => $days_in_office ]);

                $sugam_Durgam_tillDate = Carbon::today();

                if (!$posted_office->end_date) {
                    $sugam_Durgam_tillDate = $posted_office->end_date;

                }

                    // $officeStartDate = $posted_office->start_date; 
                    // $officeEndDate = $sugam_Durgam_tillDate; 
                    // $postingStartDate = $this->from_date;
                    // $postingEndDate = $this->to_date;
                if ($this->from_date->betweenIncluded($posted_office->start_date, $sugam_Durgam_tillDate) && 
                    $this->to_date->betweenIncluded($posted_office->start_date, $sugam_Durgam_tillDate)) {
                    return true;
                }

                if ($this->checkisDateInBetween($posted_office->start_date, $sugam_Durgam_tillDate, $this->from_date, $this->to_date)) {
                    $duration_factor = $posted_office->duration_factor;
                    $days_in_office = $duration_factor * (int)(Carbon::parse($this->from_date)->diffInDays(Carbon::parse($this->to_date)));
                    $days_in_office = $days_in_office + 1;
                }
                else
                {

                     

                }
                // ToDo:: Ankit find ->  durgam 


              
            }


            return $days_in_office;

            // if ($this->to_date) {
            //     $days_in_office = $duration_factor * (int)(Carbon::parse($this->from_date)->diffInDays(Carbon::parse($this->to_date)));

            //     $days_in_office = $days_in_office + 1;

            //     // $this->update([
            //     //     'days_in_office' => $days_in_office
            //     // ]);
            // } else {

            //     $days_in_office =   $duration_factor * (int)Carbon::today()->diffInDays(Carbon::parse($this->from_date));
            // }

            // return Helper::getRefinedDayMonthYearFromDays($days_in_office);
        }
    }

    public function checkisDateInBetween($officeStartDate, $officeEndDate, $postingStartDate, $postingEndDate)
    {
        if ($postingStartDate > $postingEndDate) {
            return false;
        }

       

        return false;
    }
}
