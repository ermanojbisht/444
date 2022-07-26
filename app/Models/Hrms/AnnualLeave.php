<?php

namespace App\Models\Hrms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnualLeave extends Model
{
    use HasFactory;

    public $table = 'annual_leaves'; 
    protected $dates = ['created_at','updated_at'];
   
    protected $fillable = [
        'id',
        'employee_id',
        'transfer_seasion',
        'No_of_leaves',
        'Office_name',
        'isdurgam',
        'duration_factor',
        'created_at',
        'updated_at'
    ];

     

}
