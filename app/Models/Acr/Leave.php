<?php

namespace App\Models\Acr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;
    protected  $fillable =['acr_id','type_id','from_date','to_date'];
    protected $dates = [
        'from_date', 'to_date'
    ];
    
}
