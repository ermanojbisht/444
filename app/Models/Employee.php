<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Models\Acr\Acr;
use App\Models\Acr\AcrMasterTraining;
use App\Models\Acr\EmpProposedTraining;
use App\Models\HrGrievance\HrGrievance;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Employee extends Authenticatable
{
	use Notifiable;

    public $table = 'employees';
    public $fulltable = 'mispwd.employees';
    protected $connection='mysqlmispwd';

    protected $hidden = [
        'remember_token',    'password',
    ];
    protected $fillable = [
         'id',
		  'name',
		  'phone_no',
		  'phone_no1',
		  'chat_id',
		  'chat_id1',
		  'office_id',
		  'father_name',
		  'joining_date',
		  'birth_date',
		  'retirement_date',
		  'office_type',
		  'designation_id','password', 'remember_token'
    ];
    protected $dates = ['joining_date','birth_date','retirement_date'];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

     /**
     * Route notifications for the Telegram channel.
     *
     * @return int
     */
    public function routeNotificationForTelegram()
    {
        return $this->chat_id;
    }
	/*protected static function boot()
    {
        
    }*/
    public function designation()
    {
    	return $this->belongsTo(Designation::class)->withDefault(function ($designation) {
            $designation->name = 'Unknown';
        });
    }

    public function getNameempAttribute()
    {
        return $this->name.":".$this->id;
    }

    public function getShriNameAttribute()
    {
        switch ($this->gender) {
            case 'Male':
                $shri="Mr. ";
                break;
            case 'Female':
                $shri="Ms. ";
                break;
            
            default:
                $shri="";
                break;
        }
        if($this->designation){
            if ($this->designation->group_id==1){
                $shri="Er. ";
            }
        }
        return $shri.$this->name;
    }
    /**
     * Scope a query to only include AE Emp.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAeOnly($query)
    {
        return $query->whereIn('designation_id',  [7,8,9,10,11,12,62]);
    }

    public function scopeQrcodeNotRequested($query)
    {
        //"Draftsman,Junior Engineer Civil,Junior Engineer Technical,Junior Engineer Electrical,Junior Engineer Mechnical,Additional Assistant Engineer Civil,Additional Assistant Engineer (Electric),Assistant Engineer Civil,Assistant Engineer E/M,Executive Engineer Civil,Executive Engineer E/M,Superintending Engineer Civil,Superintending Engineer E/M,Chief Engineer Level-II,Chief Engineer Level-I,Engineer In Chief,Additional Assistant Engineer (Technical),Additional Assistant Engineer (Mechnical),Assistant Geologist,Chief Administrative Officer (Division Office),Senior Administrative Office (Division Office),Administrative Office (Division Office),Head Assistant (Division Office),Senior Assistant (Division Office),Junior Assistant (Division Office),Chief Personal Officer (EE office),Personal Officer (EE office),Senior Personal Assistant (Division Office),Personal Assistant (Division Office),JE Civil (Samvida),AE Civil (Samvida),JE Civil (Res),"
        
        return $query->whereNotIn('id', DB::table('qrrequests')->pluck('emp_code')->toArray())
        ->selectRaw('employees.id,concat(name," ", id) as name ')->orderBy('name')
        ->whereIn('designation_id',  [13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,37,40,43,46,49,52,55,58,61,64,106,107,108])
        ->get();
    }

    public function grievances()
    {
    	return $this->hasMany(HrGrievance::class, "employee_id", "id");
    }

    public function detailAsHtml()
    {
        $designation=($this->designation)?$this->designation->name:'Not found';

        $d=$this->designation;
        $dob=($this->birth_date)?$this->birth_date->format('d M y'):'unknown';
        return "
            Name:$this->name <br>
            Father/Spouse:$this->father_name <br>
            Designation:$designation <br>
            DOB:$dob <br>            
        ";
    }

    public function education()
    {
        return $this->hasMany(Education::class, "employee_id", "id");
    }

    public function EmployeeProposedTrainings()
    {
        return $this->hasMany(EmpProposedTraining::class, "employee_id", "id");
    }

    public function trainnings()
    {
        return $this->belongsToMany(AcrMasterTraining::class, 'emp_proposed_trainings', 'employee_id','training_id')
            ->withPivot('is_active')->withTimestamps();
    }

    public function acrs()
    {
         return $this->hasMany(Acr::class);
    }

    public function activeAcrs()
    {
         return $this->acrs()->where('is_active',1);
    }

     public function checkAcrDateInBetweenPreviousACRFilled($start, $end , $excludidAcrId = false)
    {
        if ($start > $end) {
            return ['status' => false, 'msg' => 'From date ' . $start->format('d M y') . ' can not be less then To date' . $end->format('d M y')];
        }

        if(Helper::currentFy($start->year, $start->month)!==Helper::currentFy($end->year, $end->month)){
            return ['status' => false, 'msg' => 'From date ' . $start->format('d M y') . '  To date' . $end->format('d M y') .' should be of one financial year '];
        }
        //this ACR should not intersect // period overlaps with previos ACR line period record  
        $otherRecords = $this->activeAcrs()->get();

        foreach ($otherRecords as  $record) {
            
            if ($record->id == $excludidAcrId) { continue;   }

            $recordPeriod = CarbonPeriod::create($record->from_date, $record->to_date);
            if ($recordPeriod->overlaps($start, $end)) {
                return ['status' => false, 'msg' => 'Given period (' . $start->format('d M y') . ' - ' .
                    $end->format('d M y') . ') intersect with period ( ' .
                    $record->from_date->format('d M y') . ' - ' . $record->to_date->format('d M y') .
                    ' ) in our record Employee ID = ' . $record->employee_id];
            }
        }
        return ['status' => true, 'msg' => ''];
    }
    
}


