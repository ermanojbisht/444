<?php

namespace App\Models\Acr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcrBasic extends Model
{
    use HasFactory;
    protected  $fillable =['acr_id','prpoerty_return_date','good_work','difficultie','appreciations'];
    public $timestamps = false;
}
