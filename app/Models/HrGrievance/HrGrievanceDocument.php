<?php

namespace App\Models\HrGrievance;

use Illuminate\Database\Eloquent\Model;


class HrGrievanceDocument extends Model
{
	protected $dates = ['created_at','updated_at'];
    protected $fillable = [ 'hr_grivance_id', 'name', 'address', 'is_question', 'description', 'created_at', 'is_active', 'updated_at', 'uploaded_by'];
    
 
    
    public function hrGrivance()
    {
    	return $this->belongsTo(HrGrievance::class);
    }

    
}
