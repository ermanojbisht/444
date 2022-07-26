<?php

namespace App\Models\Hrms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeHeadQuarter extends Model
{
    use HasFactory;

    public $table = 'office_head_quarters';
    public $timestamps =false;
    public $fulltable = 'office_head_quarters';

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

