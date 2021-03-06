<?php

namespace App\Models\HrGrievance;

use Illuminate\Database\Eloquent\Model;


class HrGrievanceDocument extends Model
{
	protected $connection='mysqlhrms';
    protected $dates = ['created_at','updated_at'];
    protected $fillable = [ 'hr_grievance_id', 'name', 'address', 'is_question', 'description', 'created_at', 'is_active', 'updated_at', 'uploaded_by'];
    
 
    
    public function hrGrievance()
    {
    	return $this->belongsTo(HrGrievance::class);
    }

    
}
