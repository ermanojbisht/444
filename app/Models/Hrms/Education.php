<?php

namespace App\Models\Hrms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    public $table = 'educations';
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'employee_id',
        'qualification_type_id',
        'qualification',
        'year',
        'updated_by',
        'created_at',
        'updated_at'
    ];


    public function education_type()
    {
        return config('hrms.masters.qualificationType')[$this->qualifiaction_type_id]; 
    }
    
}
