<?php

namespace App\Models\Hrms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherOffice extends Model
{
    use HasFactory;

    public $table = 'other_offices'; 
    public $timestamps =false;
    public $fulltable = 'other_offices';

     

    protected $fillable = [
        'id',
        'name',
        'name_h',
        'parent_id',
        'is_exist',
        '_lft',
        '_rgt',
        'hr_office_id',
        'isdurgam',
        'duration_factor',
    ];

}

