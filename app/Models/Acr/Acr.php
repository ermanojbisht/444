<?php

namespace App\Models\Acr;

use App\Models\Employee;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use  App\Models\Acr\AcrType;

class Acr extends Model
{
	protected $table = 'acrs';

	protected $fillable = [
		'employee_id', 'acr_type_id', 'office_id', 'from_date', 'to_date', 'prpoerty_return_date','good_work','difficultie','appreciations'
	];

	public function acrMasterParameters()
	{
		return $this->hasMany(AcrMasterParameter::class, 'acr_type_id', 'acr_type_id');
	} 
	
	public function type(){
		return $this-> belongsTo(AcrType::class, 'acr_type_id', 'id');
	}

	public function getEmployeeData()
	  {
	    return $this->belongsTo(Employee::class, 'employee_id', 'id');
	  }

} 
