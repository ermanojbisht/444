<?php

namespace App\Models\Hrms;

use App\Models\Hrms\District;
use App\Models\Tehsil;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class Address extends Model
{
    use HasFactory;
    public $table = 'addresses'; 

    protected $fillable = [
        'id', 
        'employee_id', 
        'address1', 
        'address2', 
        'address_type_id', 
        'state_id', 
        'district_id', 
        'tehsil_id',
        'vidhansabha_id', 
        'updated_by', 
        'created_at', 
        'updated_at'
    ];

    public function address_type(){
        return config('hrms.masters.addressType')[$this->address_type_id]; 
    }


    // todo: state table need to be corrected 
    

    public function state(){
        return $this->belongsTo(State::class, "state_id", "id");
    }
    
    public function district(){
        return $this->belongsTo(District::class, "district_id", "id");
    }

    public function tehsil(){
        return $this->belongsTo(Tehsil::class, "tehsil_id", "id");
    }

    public function constituency(){
        return $this->belongsTo(Constituency::class, "vidhansabha_id", "id");
    }

    public function employee(){
        return $this->belongsTo(Employee:: class);
    }

}

