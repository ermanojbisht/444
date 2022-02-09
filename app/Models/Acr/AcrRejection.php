<?php

namespace App\Models\Acr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcrRejection extends Model
{
  protected  $fillable =[ 'acr_id', 'employee_id', 'remark'];

}
   