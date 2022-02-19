<?php

namespace App\Models\Acr;

use Illuminate\Database\Eloquent\Model;

class AcrRejection extends Model
{
  protected $connection='mysqlhrms';
  protected  $fillable =[ 'acr_id', 'employee_id', 'remark','rejection_type_id'];
  protected $dates = ['created_at'];

}
   
