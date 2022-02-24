<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{   

    //public $table = 'educations';
    public $table = 'empedu_detail';
    //protected $keyType = 'string';
    //protected $connection='mysqlhrms';
    protected $connection='sqlsrv';


    /*protected $fillable = [
        'id',
        'employee_id',
        'qualifiaction',
        'year',
        'qualifiaction_type_id'
     ];*/

     /*emp_code  
    emp_category  
    emp_qual  
    emp_board  
    emp_stream  
    emp_year  
    emp_per  
    emp_mode  
    emp_type*/




    /* public function education_type(){
        return $this->belongsTo(EducationType::class, "qualifiaction_type_id", "id");
    }*/

    public function getQualifiactionAttribute()
    {        
        return $this->emp_qual;
    }

    public function getQualifiactionTypeIdAttribute()
    {        
        if($this->emp_type==='Additional'){
            return 2;
        }
        return 1;
    }



}
