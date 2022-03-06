<?php

namespace App\Models\Acr;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $connection='mysqlhrms';
    protected  $fillable =['employee_id','type_id','from_date','to_date'];
    protected $dates = [
        'from_date', 'to_date'
    ];
    
}
