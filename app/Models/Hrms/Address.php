<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NunoMaduro\Collision\Adapters\Phpunit\State;

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
        'vidhansabha_id', 
        'updated_by', 
        'created_at', 
        'updated_at'
    ];

    public function address_type(){
        return config('hrms.masters.addressType')[$this->address_type_id]; 
    }
    // todo: state table need to be corrected 
    public function stae_Name(){
        return $this->belongsTo(State::class, "state_id", "id");
    }
    
    public function district_Name(){
        return $this->belongsTo(District::class, "district_id", "id");
    }

    public function tehsil_Name(){
        return $this->belongsTo(Tehsil::class, "tehsil_id", "id");
    }


}
