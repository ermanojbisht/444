<?php

namespace App\Models\Acr;

use Illuminate\Database\Eloquent\Model;

class AppraisalOfficer extends Model
{
    protected $dates = [
        'from_date', 'to_date'
    ];
    public $timestamps = false;
    protected $connection='mysqlhrms';
    // public $incrementing = false;
    // $primarykey = ['acr_id', 'appraisal_officer_type', 'employee_id', 'from_date'];
    protected $fillable = ['acr_id', 'appraisal_officer_type','employee_id', 'from_date', 'to_date', 'is_due'];

}
