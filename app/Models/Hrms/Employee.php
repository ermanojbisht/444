<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $table = 'employees';
    
    protected $fillable = [
        'id',
        'name',
        'father_name',
        'dob',
        'doj',
        'dor',
        'm_gender_id',
        'm_religions_id',
        'm_cast_categories_id',
        'm_benifit_categories_id',
        'contact_no_1',
        'contact_no_2',
        'contact_no_3',
        'contact_no_4',
        'email',
        'pan_no',
        'aadhar_no',
        'height',
        'identity_mark',
        'marital_id',
        'blood_group_id',
        'current_office_id',
        'current_designation_id',
        'section_inform_date',
        'section_user_id',
        'transfer_order_date',
        'is_office_head',
        'is_locked_by_cao',
        'is_self_locked'
    ];

    public function current_office(){
        return $this->belongsTo(Office::class, "current_office_id", "id");
    }

    public function designation(){
        return $this->belongsTo(Designation::class, "current_designation_id", "id");
    }

    public function gender(){
        return $this->belongsTo(Gender::class, "gender_id", "id");
    }
    public function religion(){
        return $this->belongsTo(Religion::class, "religions_id", "id");
    }
    public function castCategory(){
        return $this->belongsTo(Category::class, "cast_categories_id", "id");
    }
    
    public function benifitCategory(){
        return $this->belongsTo(SubCategory::class, "benifit_categories_id", "id");
    }
  
    public function martialStatus(){
        return $this->belongsTo(Martial::class, "marital_id", "id");
    }
   
    public function bloodGroup(){
        return $this->belongsTo(BloodGroup::class, "blood_group", "id");
    }


    // public function getEmpEducation(){
    //     //return $this->hasMany(Education::class, "id", "emp_code");
    //     return $this->hasMany(Education::class, "id", "emp_id");
    // }

    // public function getEmpHistory(){
    //     return $this->belongsTo(TransferDetail::class, "id", "emp_id");
    // }



}
