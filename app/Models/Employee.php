<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use DB;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\Employee
 *
 * @property string $id
 * @property string|null $name
 * @property int|null $phone_no
 * @property int|null $phone_no1
 * @property int|null $chat_id
 * @property int|null $chat_id1
 * @property int|null $office_type 1=ce,2=se,3=ee,0=enc
 * @property int|null $office_id
 * @property string|null $father_name
 * @property \Illuminate\Support\Carbon|null $joining_date
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property \Illuminate\Support\Carbon|null $retirement_date
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property int|null $designation_id
 * @property string|null $gender
 * @property string|null $h_district
 * @property string|null $h_state
 * @property string|null $h_tahsil
 * @property string|null $c_email
 * @property int|null $c_mobile
 * @property int|null $s_y
 * @property int|null $s_m
 * @property int|null $s_d
 * @property int|null $s_t
 * @property int|null $d_y
 * @property int|null $d_m
 * @property int|null $d_d
 * @property int|null $d_t
 * @property string|null $last_office_name
 * @property int|null $last_office_type
 * @property int|null $orignal_office_days
 * @property string|null $orignal_office_name
 * @property int|null $orignal_office_type
 * @property int|null $durgam_days_reduction
 * @property int|null $is_locked
 * @property-read \App\Models\Designation|null $designation
 * @property-read mixed $nameemp
 * @method static Builder|Employee aeOnly()
 * @method static Builder|Employee newModelQuery()
 * @method static Builder|Employee newQuery()
 * @method static Builder|Employee qrcodeNotRequested()
 * @method static Builder|Employee query()
 * @method static Builder|Employee whereBirthDate($value)
 * @method static Builder|Employee whereCEmail($value)
 * @method static Builder|Employee whereCMobile($value)
 * @method static Builder|Employee whereChatId($value)
 * @method static Builder|Employee whereChatId1($value)
 * @method static Builder|Employee whereCreatedAt($value)
 * @method static Builder|Employee whereDD($value)
 * @method static Builder|Employee whereDM($value)
 * @method static Builder|Employee whereDT($value)
 * @method static Builder|Employee whereDY($value)
 * @method static Builder|Employee whereDesignationId($value)
 * @method static Builder|Employee whereDurgamDaysReduction($value)
 * @method static Builder|Employee whereFatherName($value)
 * @method static Builder|Employee whereGender($value)
 * @method static Builder|Employee whereHDistrict($value)
 * @method static Builder|Employee whereHState($value)
 * @method static Builder|Employee whereHTahsil($value)
 * @method static Builder|Employee whereId($value)
 * @method static Builder|Employee whereIsLocked($value)
 * @method static Builder|Employee whereJoiningDate($value)
 * @method static Builder|Employee whereLastOfficeName($value)
 * @method static Builder|Employee whereLastOfficeType($value)
 * @method static Builder|Employee whereName($value)
 * @method static Builder|Employee whereOfficeId($value)
 * @method static Builder|Employee whereOfficeType($value)
 * @method static Builder|Employee whereOrignalOfficeDays($value)
 * @method static Builder|Employee whereOrignalOfficeName($value)
 * @method static Builder|Employee whereOrignalOfficeType($value)
 * @method static Builder|Employee wherePhoneNo($value)
 * @method static Builder|Employee wherePhoneNo1($value)
 * @method static Builder|Employee whereRetirementDate($value)
 * @method static Builder|Employee whereSD($value)
 * @method static Builder|Employee whereSM($value)
 * @method static Builder|Employee whereST($value)
 * @method static Builder|Employee whereSY($value)
 * @method static Builder|Employee whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

    
}


