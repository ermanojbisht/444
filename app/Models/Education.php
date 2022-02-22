<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    public $table = 'educations';
    protected $keyType = 'string';
    protected $connection='mysqlhrms';
    protected $fillable = [
        'id',
        'employee_id',
        'qualifiaction',
        'year',
        'qualifiaction_type_id'
     ];


     public function education_type(){
        return $this->belongsTo(EducationType::class, "qualifiaction_type_id", "id");
    }



}
