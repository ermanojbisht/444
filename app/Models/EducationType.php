<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationType extends Model
{
    use HasFactory;
    public $table = 'm_qualification_types';
    protected $keyType = 'string';

    protected $fillable = [
         'id',
         'name'
    ];

}
