<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    public $table = 'leaves';

    protected $fillable = [
        'id',
        'employee_id',
        'leave_type_id',
        'from_date',
        'to_date',
        'office_id',
        'created_at',
        'updated_at'
    ];

}

