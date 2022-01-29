<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class OfficeJobDefault extends Model
{
    public $table = 'office_job_defaults';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'office_id',
        'job_id',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function user()
    {
       return $this->belongsTo(User::class, 'user_id');
    }
    public function jobType()
    {
        return $this->belongsTo(OfficeJob::class, 'job_id');
    }
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}