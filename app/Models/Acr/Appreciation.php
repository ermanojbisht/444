<?php

namespace App\Models\Acr;

use Illuminate\Database\Eloquent\Model;

class Appreciation extends Model
{
    protected $connection='mysqlhrms';
    protected $fillable = ['acr_id', 'appreciation_type','detail'];
    
}
