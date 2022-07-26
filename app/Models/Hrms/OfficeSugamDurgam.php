<?php

namespace App\Models\Hrms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeSugamDurgam extends Model
{
    use HasFactory;

    public $table = 'office_sugam_durgams';
    protected $dates = ['start_date', 'end_date', 'created_at', 'updated_at']; 

    protected $fillable = [
        'id',
        'office_id',
        'table_name',
        'start_date',
        'end_date',
        'isdurgam',
        'duration_factor',
        'hr_office_id',
        'created_at', 
        'updated_at'
    ];

}
 