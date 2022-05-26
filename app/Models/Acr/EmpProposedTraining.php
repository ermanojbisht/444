<?php

namespace App\Models\Acr;

use Illuminate\Database\Eloquent\Model;

class EmpProposedTraining extends Model
{
    protected $connection='mysqlhrms';
    protected  $fillable =['employee_id','training_id','is_active'];
    //public $timestamps = false;
    //
    public function trainning()
    {
        return $this->belongsTo(AcrMasterTraining::class, 'training_id', 'id');
    }

}
