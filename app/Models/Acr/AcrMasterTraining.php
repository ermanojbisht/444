<?php

namespace App\Models\Acr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcrMasterTraining extends Model
{
    use HasFactory;

    public function employee()
    {
        return $this->belongsToMany(Employee::class, 'emp_proposed_trainings', 'training_id', 'employee_id')
            ->withPivot('is_active');
    }

}
