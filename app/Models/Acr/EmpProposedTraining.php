<?php

namespace App\Models\Acr;

use Illuminate\Database\Eloquent\Model;

class EmpProposedTraining extends Model
{
    protected $connection='mysqlhrms';
    protected  $fillable =['employee_id','training_id','is_active'];
    //public $timestamps = false;

}
