<?php

namespace App\Models\Acr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcrPersonalAttribute extends Model
{
    protected  $fillable =['acr_id','personal_attribute_id','reporting_marks','reviewing_marks'];
    public $timestamps = false;
    protected $table = 'acr_personal_attributes';
}
