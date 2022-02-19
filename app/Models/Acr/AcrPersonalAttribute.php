<?php

namespace App\Models\Acr;

use Illuminate\Database\Eloquent\Model;

class AcrPersonalAttribute extends Model
{
    protected $connection='mysqlhrms';
    protected  $fillable =['acr_id','personal_attribute_id','reporting_marks','reviewing_marks'];
    public $timestamps = false;
    protected $table = 'acr_personal_attributes';
}
