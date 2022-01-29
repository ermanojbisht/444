<?php

namespace App\Models;


use App\Models\OfficeJobDefault;
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
use Laravel\Passport\HasApiTokens;
use \DateTimeInterface;

class User extends Authenticatable implements MustVerifyEmail
{
    use SoftDeletes, Notifiable, HasApiTokens,UserOfficesTrait;

    public $table = 'users';

    protected $hidden = [
        'remember_token',    'password',
    ];

    protected $dates = [
        'email_verified_at',    'verified_at',    'created_at',    'updated_at',    'deleted_at',
    ];

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
 


    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (User $user) {
            if (auth()->check()) {
                $user->verified    = 1;
                $user->verified_at = Carbon::now()->format(config('panel.date_format') . ' ' . config('panel.time_format'));
                $user->save();
            } elseif (!$user->verification_token) {
                $token     = Str::random(64);
                $usedToken = User::where('verification_token', $token)->first();

                while ($usedToken) {
                    $token     = Str::random(64);
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

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function getVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setVerifiedAtAttribute($value)
    {
        $this->attributes['verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    /**
     * [mkb hasAccess checks only permission table used in hasPermissionTo]
     * @param  [type]  $permission [description]
     * @return boolean             [description]
     */
    public function hasAccess($permission)
    {
        return $this->permissions()->whereIn('name',$permission)->get()->count();
    }

    public function userAllOffices()
    {
        $offices = DB::table('user_offices')
            ->where('user_id', $this->id)
            ->get();
        $offices = collect($offices)->map(function ($x)
        {
            return (array) $x;})
            ->toArray();

        return $this->userOfficesaAsPerArray($offices);
    }

    public function userDirectOffices()
    {
        $offices = DB::table('user_offices')
            ->where('user_id', $this->id)
            ->get();
        $offices = collect($offices)->map(function ($x)
        {
            return (array) $x;})
            ->toArray();

        return $this->userDirectOfficesaAsPerArray($offices);

    }


    public function onlyEEOffice()
    {
        $all= $this->userAllOffices();
        if(isset($all['ee'])){
            if($all['ee']){
                return $all['ee']; //id and name array of object
            }
        } 
        return false;
    }

    /**
     * Checks if User has access to any $permissions.
     * 
     */
    public function hasPermissionTo(array $permission) : bool //mkb checked
    {
        // check if the permission is available in any role
        foreach ($this->roles as $role) {
            if($role->hasAccess($permission)) {
                return true;
            }
        }
        // check if the permission is available in any particular permission
        if($this->hasAccess($permission)) {
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

    public function relatedOfficeToAnyJobs($jobs=[])
    {
        return OfficeJobDefault::where('user_id',$this->id)->whereIn('job_id',$jobs)->get()->pluck('office_id');
    }



}
