<?php

namespace App\Models\Acr;



use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Acr extends Model
{
	protected $table = 'acrs';

	public function acrMasterParameters(){
		return $this-> hasMany(AcrMasterParameter::class, 'acr_type_id', 'acr_type_id');
	}
}