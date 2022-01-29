<?php

namespace App\Models\Track\Grivance;

use Illuminate\Database\Eloquent\Model;


class HrGrivanceDocument extends Model
{
	protected $dates = ['created_at','updated_at'];
    protected $fillable = [ 'hr_grivance_id', 'name', 'address', 'is_question', 'description', 'created_at', 'is_active', 'updated_at', 'uploaded_by'];
    
    
    public function hrGrivance()
    {
    	return $this->belongsTo(HrGrivance::class);
    }

    
}
