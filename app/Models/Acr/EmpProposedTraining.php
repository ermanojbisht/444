<?php

namespace App\Models\Acr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpProposedTraining extends Model
{
    use HasFactory;
    protected  $fillable =['employee_id','training_id','is_active'];
    //public $timestamps = false;

}
