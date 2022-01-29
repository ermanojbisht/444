<?php

namespace App\Models\Track\Grivance;

use App\Models\Employee;
use App\Models\User;
use Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\OfficeTypeTrait;

class HrGrivance extends Model {

    use OfficeTypeTrait;

    protected $fillable = [ 'id','grivance_type_id','description','office_type', 
    'office_id','draft_answer','final_answer','employee_id','refference_grivance_id','status_id'];

    public function grivanceType() {
        return $this->belongsTo(HrGrivanceType::class, "grivance_type_id", "id");
    }

    public function creator() {
        return $this->belongsTo(Employee::class, "employee_id", "id");
    }

    public function currentStatus() {
        $status = [0=>'pending',1=>'draft',2=>'final',3=>'reopened'];
        return  $status[$this->status_id];
    }
 
    public function office() {
        return  $this->OfficeName($this->office_type, $this->office_id);
    }

    
    
    

    
    /**
     * @return mixed
     */
    public function documents()
    {
        return $this->hasMany(HrGrivanceDocument::class);
    }

    
    /**
     * @param  $doctitle
     * @return mixed
     */
    public function checkSimlirityOfDocTitle($doctitle)
    {
        $alldoc = $this->documents()->get();

        $new_title = Str::slug($doctitle, '-');
        foreach ($alldoc as $doc) {
            $already_in_record_title = Str::slug($doc->name, '-');
            if ($new_title == $already_in_record_title) {
                return true;
            }
        }
        return false;
    }



}
