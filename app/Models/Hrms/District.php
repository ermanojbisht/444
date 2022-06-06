<?php

namespace App\Models\Hrms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    public $table = 'mispwd.districts';
    public $fulltable = 'mispwd.districts';
    protected $connection='mysqlmispwd';

    protected $fillable = [
        'id',
        'name',
        'state_id'
     ];

     
    // public function state(){
    //     return $this->belongsTo(state::class);
    // }

   

}