<?php

namespace App\Models\Hrms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    // public $table = 'mispwd.constituencies';
    // public $fulltable = 'mispwd.constituencies';
    // protected $connection='mysqlmispwd';
    
    public $table = 'states';

    protected $fillable = [
        'id',
        'name',       
    ];


}
