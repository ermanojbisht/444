<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferDetail extends Model
{
    use HasFactory;

    public $table ='postings'; 
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

    public function office_Name(){
        if($this->office_type_id == "1" )
            return $this->belongsTo(Zone::class, "office_id", "hr_office_id");
        else if($this->office_type_id == "2" )
            return $this->belongsTo(Circle::class, "office_id", "hr_office_id");
        else
            return $this->belongsTo(Division::class, "office_id", "hr_office_id");
    }


    public function designation_Name(){
        return $this->belongsTo(Designation::class, "designation_id", "id");
    }


}
