<?php

namespace App\Models\Acr;


use Illuminate\Database\Eloquent\Model;

class AcrNegativeParameter extends Model
{

    protected $connection='mysqlhrms';
    protected  $fillable =['acr_id','acr_master_parameter_id','row_no','col_1','col_2','col_3','col_4','col_5','col_6','col_7','col_8','col_9'];
    public $timestamps = false;
}
