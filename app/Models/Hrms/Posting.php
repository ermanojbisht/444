<?php

namespace App\Models\Hrms;

use App\Models\Designation;
use App\Models\Office;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posting extends Model
{
    use HasFactory;

    public $table ='postings'; 
    protected $dates = ['from_date','to_date','order_at','created_at','updated_at'];
    protected $keyType = 'string';

    protected $fillable = [
        'id', 
        'employee_id', 
        'order_no', 
        'order_at', 
        'office_id', 
        'from_date', 
        'to_date', 
        'mode_id', 
        'designation_id', 
        'islocked', 
        'row_confirm', 
        'created_at', 
        'updated_at'
    ];

    // public function state(){
    //     return $this->belongsTo(state::class);
    // }

    public function officeName(){
         
            return $this->belongsTo(Office::class, "office_id", "id");
    }


    public function designationName(){
        return $this->belongsTo(Designation::class, "designation_id", "id");
    }


}
