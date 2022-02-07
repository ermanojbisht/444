<?php

namespace App\Models\Acr;

use Illuminate\Database\Eloquent\Model;

class AcrParameter extends Model
{   

    protected  $fillable =['acr_master_parameter_id','acr_id','user_target','user_achivement','status','reporting_marks','reviewing_marks','is_applicable'];
    public $timestamps = false;

}
