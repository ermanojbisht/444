<?php

namespace App\Models;

use App\Models\CeOffice;
use App\Models\Office;
use App\Models\SeOffice;
use Illuminate\Database\Eloquent\Model;


class OfficeJobDefault extends Model
{
    public $table = 'office_job_defaults';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'office_id',
        'job_id',
        'user_id',
        'employee_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function user()
    {
       return $this->belongsTo(User::class, 'user_id');
    }
    public function jobType()
    {
        return $this->belongsTo(OfficeJob::class, 'job_id');
    }
    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function updateHeadEmpCodeInOfficeTables()
    {
        if($this->job_id==3){
            $head_emp_code=$this->employee_id;
            $office=Office::find($this->office_id);
            switch ($office->office_type) {
                case 1:
                    CeOffice::where('id',$office->office_id)->update(['head_emp_code'=>$head_emp_code]);
                    break;
                case 2:
                    SeOffice::where('id',$office->office_id)->update(['head_emp_code'=>$head_emp_code]);
                    break;
                case 3:
                    EeOffice::where('id',$office->office_id)->update(['head_emp_code'=>$head_emp_code]);
                    break;
            }
         }
    }
}
