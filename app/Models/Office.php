<?php

namespace App\Models;

use App\Models\OfficeJobDefault;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Office extends Model
{

    use NodeTrait;
    public $timestamps =false;
    protected $connection='mysqlmispwd';
    public $fulltable = 'mispwd.offices';

    protected $fillable = [
        'id', 
        'office_id', 
        'office_type', 
        'name', 
        'name_h',
        'parrent_id',
        'is_exist',
        '_lft', 
        '_rgt',
        'hr_office_id'        
    ];
    
    public function getParentIdName()
    {
        return 'parrent_id';
    }

    public function getFinalGriveanceResolver()
    {                  
        $OfficeJobDefault = OfficeJobDefault::where('job_id', 2)->where('office_id', $this->id)->first();
        if ($OfficeJobDefault) {
            return $OfficeJobDefault->user;
        }           
        return false;
    }
 
}
