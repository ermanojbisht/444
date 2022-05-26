<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sevend extends Model
{
    use HasFactory;

    public $table = 'seven_laws'; 
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'employee_id',
        'd3',
        'd3_1',
        'd4',
        'd5',
        'd17',
        'd3_docs',
        'd3_1_docs',
        'd4_docs',
        'd5_docs',
        'd17_docs',
        'created_at',
        'updated_at'
    ];
}
