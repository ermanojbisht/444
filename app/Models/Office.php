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

    public function getParentIdName()
    {
        return 'parrent_id';
    }

    public function getFinalGriveanceResolver()
    {                  
        $OfficeJobDefault = OfficeJobDefault::where('job_id', 2)->where('office_id', $this->office_id)->first();
        if ($OfficeJobDefault) {
            return $OfficeJobDefault->user;
        }           
        return false;
    }
 
}
