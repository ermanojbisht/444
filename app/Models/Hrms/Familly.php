<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familly extends Model
{
    use HasFactory;

    public $table = 'families'; 
    protected $fillable = [
        'id',
        'employee_id',
        'relation_id',
        'name',
        'dob',
        'aadhar',
        'nominee_percentage',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function relation_Name()
    {
        return config('hrms.masters.relation')[$this->relation_id];
    }

}
