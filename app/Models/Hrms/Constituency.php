<?php

namespace App\Models\Hrms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Constituency extends Model
{
    use HasFactory;

    public $table = 'mispwd.constituencies';
    public $fulltable = 'mispwd.constituencies';
    protected $connection='mysqlmispwd';

    protected $fillable = [
        'id',
        'district_id',
        'name'        
     ];

     
    // public function state(){
    //     return $this->belongsTo(state::class);
    // }

}