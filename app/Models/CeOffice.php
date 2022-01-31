<?php

namespace App\Models;

use App\Models\OfficeJobDefault;
use App\Traits\Auditable;
use App\Traits\CanGetTableNameStatically;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;


class CeOffice extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'ce_offices';
    public $fulltable = 'mispwd.ce_offices';
    protected $connection='mysqlmispwd';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'name_h',
        'address',
        'district',
        'email_1',
        'contact_no',
        'email_2',
        'lat',
        'lon',
        'created_at',
        'updated_at',
        'deleted_at',
        'head_emp_code'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function ceOfficeSeOffices()
    {
        return $this->hasMany(SeOffice::class, 'ce_office_id', 'id');
    }
    public function SeOffices()
    {
        return $this->hasMany(SeOffice::class, 'ce_office_id', 'id');
    }

    public function eeOffices()
    {
        return $this->hasManyThrough(EeOffice::class, SeOffice::class);
    }

    public function users()
    {
        return $this->morphToMany(User::class,'user_office');
    }

    public function officeHead()
    {
        return $this->belongsTo(Employee::class, 'head_emp_code');
    }

    public function bulkUpdateHeadEmpAsUserInJobTable()
    {
        $data= $this->select('id','head_emp_code')->whereNotNull('head_emp_code')->get();
        $data->map(function($item){
            $user=User::where('employee_id',$item->head_emp_code)->first();
            if($user){
                OfficeJobDefault::updateOrCreate(
                    ['job_id'=>3, 'office_id'=>(1000+$item->id)],
                    ['job_id'=>3, 'office_id'=>(1000+$item->id),'user_id'=>$user->id,'employee_id'=>$user->employee_id]);
            }
       });
    }


}
