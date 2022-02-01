<?php

namespace App\Models\Acr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppraisalOfficer extends Model
{
    use HasFactory;
    protected $dates = [
        'from_date', 'to_date'
    ];
    
}
