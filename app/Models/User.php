<?php

namespace App\Models;

use App\Mail\Acr\AcrAlertMail;
use App\Models\Acr\Acr;
use App\Models\Acr\AcrNotification;
use App\Models\HrGrievance\HrGrievance;
use App\Models\OfficeJobDefault;
use App\Notifications\Acr\AcrAlertNotification;
use App\Notifications\VerifyUserNotification;
use App\Traits\UserOfficesTrait;
use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Mail;
use \DateTimeInterface;

class User extends Authenticatable implements MustVerifyEmail
{
    use SoftDeletes, Notifiable, HasApiTokens, UserOfficesTrait;

    /**
     * @var string
     */
    public $table = 'users';

    /*protected static function boot()
    {
    parent::boot();

    static::updating(function (User $user) {
    if (in_array('email', $user->getChanges())) {
    $user->email_verified_at = null;
    $user->sendEmailVerificationNotification();
    }
    });
    }*/

    /**
     * @var array
     */
    protected $hidden = [
        'remember_token', 'password'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'email_verified_at', 'verified_at', 'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'name_h', 'email', 'password', 'remember_token', 'notification_channel', 'notification_on', 'created_at', 'updated_at', 'oldcode', 'designation', 'approved', 'user_type', 'chat_id', 'email_verified_at', 'verified_at', 'deleted_at', 'verification_token', 'verified', 'status', 'emp_code', 'contact_no', 'remark'
    ];
    /**
     * Route notifications for the Telegram channel.
     *
     * @return int
     */
    public function routeNotificationForTelegram()
    {
        return $this->chat_id;
    }

    /**
     * @param  DateTimeInterface $date
     * @return mixed
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * @return mixed
     */
    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    /**
     * @return mixed
     */
    public function getShriNameAttribute()
    {
        if ($this->employee) {
            return $this->employee->shriName;
        }

        return $this->name;
    }

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (User $user) {
            if (auth()->check()) {
                $user->verified = 1;
                $user->verified_at = Carbon::now()->format(config('panel.date_format').' '.config('panel.time_format'));
                $user->save();
            } elseif (!$user->verification_token) {
                $token = Str::random(64);
                $usedToken = User::where('verification_token', $token)->first();

                while ($usedToken) {
                    $token = Str::random(64);
                    $usedToken = User::where('verification_token', $token)->first();
                }

                $user->verification_token = $token;
                $user->save();

                $registrationRole = config('panel.registration_default_role');

                if (!$user->roles()->get()->contains($registrationRole)) {
                    $user->roles()->attach($registrationRole);
                }

                $user->notify(new VerifyUserNotification($user));
            }
        });
    }

    /**
     * @param  $value
     * @return mixed
     */
    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format').' '.config('panel.time_format')) : null;
    }

    /**
     * @param $value
     */
    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format').' '.config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    /**
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    /**
     * @param $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * @param  $value
     * @return mixed
     */
    public function getVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format').' '.config('panel.time_format')) : null;
    }

    /**
     * @param $value
     */
    public function setVerifiedAtAttribute($value)
    {
        $this->attributes['verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format').' '.config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    /**
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * @return mixed
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class)->with('designation');
    }

    /**
     * [mkb hasAccess checks only permission table used in hasPermissionTo]
     * @param  [type]  $permission     [description]
     * @return boolean [description]
     */
    public function hasAccess($permission)
    {
        return $this->permissions()->whereIn('name', $permission)->get()->count();
    }

    /**
     * @return mixed
     */
    public function userAllOffices()
    {
        $offices = DB::table('user_offices')
            ->where('user_id', $this->id)
            ->get();
        $offices = collect($offices)->map(function ($x) {
            return (array) $x;})
            ->toArray();

        return $this->userOfficesaAsPerArray($offices);
    }

    /**
     * @return mixed
     */
    public function userDirectOffices()
    {
        $offices = DB::table('user_offices')
            ->where('user_id', $this->id)
            ->get();
        $offices = collect($offices)->map(function ($x) {
            return (array) $x;})
            ->toArray();

        return $this->userDirectOfficesaAsPerArray($offices);
    }

    /**
     * @return mixed
     */
    public function onlyEEOffice()
    {
        $all = $this->userAllOffices();
        if (isset($all['ee'])) {
            if ($all['ee']) {
                return $all['ee']; //id and name array of object
            }
        }

        return false;
    }

    /**
     * Checks if User has access to any $permissions.
     *
     */
    public function hasPermissionTo(array $permission): bool//mkb checked

    {
        // check if the permission is available in any role
        foreach ($this->roles as $role) {
            if ($role->hasAccess($permission)) {
                return true;
            }
        }
        // check if the permission is available in any particular permission
        if ($this->hasAccess($permission)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if the user belongs to role.
     */
    public function inRole(string $roleSlug)
    {
        return $this->roles()->where('name', $roleSlug)->count() == 1;
    }

    /**
     * @return mixed
     */
    public function grievances()
    {
        return $this->hasMany(HrGrievance::class, "employee_id", "employee_id");
    }

    /**
     * @return mixed
     */
    public function officeJobs()
    {
        return $this->belongsToMany
        (OfficeJob::class, 'office_job_defaults', 'user_id', 'job_id', 'id', 'id')->withPivot('office_id');
    }

    public function jobs()
    {
        $officeTable = (new Office)->fulltable;

        return OfficeJobDefault::where('user_id', $this->id)
            ->join($officeTable, 'office_job_defaults.office_id', '=', $officeTable.'.id')
            ->join('office_jobs', 'office_job_defaults.job_id', '=', 'office_jobs.id')
            ->select('office_job_defaults.id', $officeTable.'.name as office_name', 'office_jobs.name')
            ->orderBy('office_jobs.name')
            ->orderBy($officeTable.'.id')
            ->get();
    }

    /**
     * @param array $jobs
     */
    public function OfficeToAnyJob(array $jobs)
    {
        return OfficeJobDefault::where('user_id', $this->id)
            ->whereIn('job_id', OfficeJob::whereIn('name', $jobs)->get()
                    ->pluck('id'))->get()->pluck('office_id')
            ->toArray();
    }

    /**
     * @param $job
     * @param $office
     */
    public function canDoJobInOffice(string $job, int $office)
    {
        return in_array($office, $this->OfficeToAnyJob([$job]));
    }

    public function employeeDetailAsHtml()
    {
        $employee = $this->employee;
        if ($employee) {
            $designation = ($employee->designation) ? $employee->designation->name : 'Not found';
            $dob = $employee->birth_date->format('d M y');

            return "
                Name:$employee->shriName <br>
                Designation:$designation <br>
                DOB:$dob <br>
            ";
        } else {
            return "User is not designated as employee";
        }
    }

    public function fromShashan()
    {
        return substr($this->employee_id, 1, 3) == 'sec';
    }

    /**
     * @param $userPendingAcrs
     */
    public function acrAlertNotification($userPendingAcrs)
    {
        $previousNotification = AcrNotification::where('employee_id', $this->employee_id)
            ->where('acr_id', 0)
            ->where('through', 1) //for mail , may be 2 for sms
            ->where('notification_type', 10) //2=for alert
            ->whereDate('notification_on', Carbon::today())->first(); //todo search for today

        if (!$previousNotification) {
            $mail = Mail::to($this)
                ->send(new AcrAlertMail($this, $userPendingAcrs));
            if ($this->chat_id > 90000) {
                $response = $this->notify(new AcrAlertNotification($this, $userPendingAcrs));
            }

            $data = [
                'employee_id' => $this->employee_id,
                'acr_id' => 0,
                'notification_on' => now(),
                'through' => 1,
                'notification_type' => 10,
                'notification_no' => 1
            ];
            AcrNotification::create($data);
        }
    }

    /**
     * @param $dutyType
     */
    public function pendingAcrsToProcess($dutyType = 'report')
    {
        $duty = config('acr.basic.duty')[$dutyType];

        return Acr::whereNotNull($duty['triggerDate'])->where($duty['targetemployee'], $this->employee_id)
            ->where('is_active', 1)->whereNull($dutyType.'_on')->get();

        /*$reviewed = Acr::whereNotNull('submitted_at')->where('review_employee_id', $this->user->employee_id)
        ->where('is_active', 1)->whereNotNull('report_on')->whereNull('review_on')->get();*/
        /*$accepted = Acr::whereNotNull('submitted_at')->where('accept_employee_id', $this->user->employee_id)
    ->where('is_active', 1)->whereNotNull('report_on')->whereNotNull('review_on')->whereNotNull('review_no')
    ->whereNull('accept_on')->get();*/
    }
}
