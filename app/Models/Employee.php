<?php

namespace App\Models;

use App\Models\HrGrievance\HrGrievance;
use App\Models\Acr\EmpProposedTraining;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use DB;
use Illuminate\Notifications\Notifiable;


class Employee extends Authenticatable
{
	use Notifiable;
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
    	return $this->belongsTo(Designation::class);
    }

    public function getNameempAttribute()
    {
        return $this->name.":".$this->id;
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
        $dob=$this->birth_date->format('d M y');
        return "
            Name:$this->name <br>
            Father/Spouse:$this->father_name <br>
            Designation:$designation <br>
            DOB:$dob <br>
            Section:$d->section<br>
            Designation_id:$this->designation_id <br>
        ";
    }

    public function EmployeeProposedTrainings()
    {
        return $this->hasMany(EmpProposedTraining::class, "employee_id", "id");
    }

    
}


