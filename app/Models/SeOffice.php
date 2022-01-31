<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use \DateTimeInterface;


class SeOffice extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, Auditable;

    public $table = 'se_offices';
    public $fulltable = 'mispwd.se_offices';
    protected $connection='mysqlmispwd';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'name_h',
        'addresss',
        'district',
        'email_1',
        'email_2',
        'contact_no',
        'lat',
        'lon',
        'ce_office_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'head_emp_code'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function seOfficeEeOffices()
    {
        return $this->hasMany(EeOffice::class, 'se_office_id', 'id');
    }

    public function ce_office()
    {
        return $this->belongsTo(CeOffice::class, 'ce_office_id');
    }

    public function procurementNotice()
    {
        return $this->morphToMany(ProcurementNotice::class, 'procurement_noticeable');
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
                    ['job_id'=>3, 'office_id'=>(2000+$item->id)],
                    ['job_id'=>3, 'office_id'=>(2000+$item->id),'user_id'=>$user->id,'employee_id'=>$user->employee_id]);
            }
       });
    }
}
