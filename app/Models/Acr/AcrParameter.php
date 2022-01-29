<?php

namespace App\Models\Acr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcrParameter extends Model
{
    use HasFactory;

    protected  $fillable =['acr_master_parameter_id','acr_id','user_target','user_achivement','status','Reporting_marks','Reviewing_marks'];
    public $timestamps = false;

}
