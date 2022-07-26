<?php

namespace App\Models\Hrms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    public $table = 'families'; 
    protected $dates = ['birth_date','created_at','updated_at'];
   
    protected $fillable = [
        'id',
        'employee_id',
        'relation_id',
        'name',
        'birth_date',
        'nominee_percentage',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function relationName()
    {
        return config('hrms.masters.relation')[$this->relation_id];
    }

}
