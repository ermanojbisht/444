<?php

namespace App\Models\Acr;

use  App\Models\Acr\AcrType;
use App\Mail\Acr\AcrSumittedMail;
use App\Models\Acr\AcrNotification;
use App\Models\Employee;
use App\Models\User;
use App\Traits\Auditable;
use Bugsnag\DateTime\Date;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use Log;
use \DateTimeInterface;

class Acr extends Model
{
    protected $table = 'acrs';

    protected $fillable = [
        'employee_id', 'acr_type_id', 'office_id', 'from_date', 'to_date', 'prpoerty_return_date', 
        'good_work', 'difficultie', 'appreciations', 'submitted_at',
        'report_employee_id', 'review_employee_id', 'accept_employee_id', 'report_on', 'review_on', 
        'accept_on', 'is_active','appraisal_note_1','appraisal_note_2','appraisal_note_3'
    ];
    protected $dates = [
        'from_date', 'to_date'
    ];


    public function acrMasterParameters()
    {
        return $this->hasMany(AcrMasterParameter::class, 'acr_type_id', 'acr_type_id');
    }

    public function type()
    {
        return $this->belongsTo(AcrType::class, 'acr_type_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    /**
     * The roles that belong to the Acr
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function appraisalOfficers()
    {
        return $this->belongsToMany(Employee::class, 'appraisal_officers', 'acr_id', 'employee_id')
            ->withPivot('appraisal_officer_type', 'from_date', 'to_date', 'is_due');
    }

    public function appraisalOfficerRecords()
    {
        return $this->hasMany(AppraisalOfficer::class);
    }



    public function checkPeriodInput($start, $end, $appraisal_officer_type)
    {
        $acrPeriodStartDate = $this->from_date;
        $acrPeriodEndDate = $this->to_date;
        //$start<$end //return with msg "start/from date can not be less then end/to date"
        if ($start > $end) {
            return ['status' => false, 'msg' => 'start/from date ' . $start->format('d M y') . ' can not be less then end/to date' . $end->format('d M y')];
        }
        //$start,$end within $acrPeriodStartDate,$acrPeriodEndDate //start and end date should be within ACR period as mentioned by you

        if (!$start->betweenIncluded($acrPeriodStartDate, $acrPeriodEndDate)) {
            return ['status' => false, 'msg' => 'start/from date ' . $start->format('d M y') . ' is beyond the ACR period (' . $acrPeriodStartDate->format('d M y') . ' - ' . $acrPeriodEndDate->format('d M y') . ' )'];
        }

        if (!$end->betweenIncluded($acrPeriodStartDate, $acrPeriodEndDate)) {
            return ['status' => false, 'msg' => 'End/to date ' . $end->format('d M y') . ' is beyond the ACR period (' . $acrPeriodStartDate->format('d M y') . ' - ' . $acrPeriodEndDate->format('d M y') . ' )'];
        }

        //same officer level it should not intersect // period overlaps with previos line at record no
        $otherRecords = $this->appraisalOfficerRecords()->where('appraisal_officer_type', $appraisal_officer_type)->get();
        foreach ($otherRecords as  $record) {
            $recordPeriod = CarbonPeriod::create($record->from_date, $record->to_date);
            if ($recordPeriod->overlaps($start, $end)) {
                return ['status' => false, 'msg' => 'Given period (' . $start->format('d M y') . ' - ' .
                    $end->format('d M y') . ') intersect with period ( ' .
                    $record->from_date->format('d M y') . ' - ' . $record->to_date->format('d M y') .
                    ' ) in our record Employee ID = ' . $record->employee_id];
            }
            //if old record has already period for 90 days then revert
            if ($recordPeriod->count() >= 90) {
                return ['status' => false, 'msg' => 'Period ( ' . $record->from_date->format('d M y') . ' - ' .
                    $record->to_date->format('d M y') . ' ) in our Employee ID=' . $record->employee_id .
                    ' already has ' . $recordPeriod->count() . ' days'];
            }
        }
        return ['status' => true, 'msg' => ''];
    }


    public function hasAppraisalOfficer($appraisal_officer_type)
    {
        return $this->appraisalOfficers()->wherePivot('appraisal_officer_type', $appraisal_officer_type)->count();
    }

    public function isSubmitted()
    {
        return ($this->submitted_at) ? true : false;
    }


    public function updateIsDue($appraisal_officer_type)
    {
        $records = $this->appraisalOfficerRecords()->whereAppraisalOfficerType($appraisal_officer_type)->orderBy('from_date')->get();
        $responsible_employee_id = '';
        foreach ($records as $key => $record) {
                
            Log::info(print_r($record, true));

            if ($record->from_date->diffInDays($record->to_date) >= 90 && $responsible_employee_id === '') {
                $record->is_due = 1;
                $responsible_employee_id = $record->employee_id;
            } else {
                $record->is_due = 0;
            }
            $record->save();
        }
        $this->update([config('acr.basic.acrProcessFields')[$appraisal_officer_type] => $responsible_employee_id]);
    }

    public function filledparameters()
    {
        return $this->hasMany(AcrParameter::class);
    }

    public function fillednegativeparameters()
    {
        return $this->hasMany(AcrNegativeParameter::class);
    }

    public function type1RequiremntsWithFilledData()
    {
       $filledparameters=$this->filledparameters()->get()->keyBy('acr_master_parameter_id');
        $requiredParameters=$this->acrMasterParameters()->where('type',1)->get();
        $requiredParameters->map(function($row) use ($filledparameters){
            if(isset($filledparameters[$row->id])){
                $row->user_target=$filledparameters[$row->id]->user_target;
                $row->user_achivement=$filledparameters[$row->id]->user_achivement;
                $row->status=$filledparameters[$row->id]->status;
            }else{
                $row->user_target=$row->user_achivement=$row->status='';
            }
            return $row;
        });
        return $requiredParameters->groupBy('config_group');
    }


    public function getPdfFilePathAttribute()
    {
        return 'acr/'.$this->employee_id.'/'.$this->id.'.pdf';
    }

    public function getPdfFullFilePathAttribute()
    {
        return \Storage::disk('public')->path($this->pdf_file_path);
    }



    public function isFileExist()
    {
      return \Storage::disk('public')->exists($this->pdf_file_path);
    }

    public function createPdfFile($pdf,$forced=true)
    {
        //$fullpath=\Storage::disk('public')->path($this->pdf_file_path);
        if( $forced || (!$this->isFileExist()) ){
            if($this->isFileExist()){
                \Storage::disk('public')->delete($this->pdf_file_path);
            }
            $pdf->save(\Storage::disk('public')->path($this->pdf_file_path));
        }
    }

    public function submitNotification()
    {
        Log::info("in submitNotification $this->id");
        $acruser=User::where('employee_id',$this->employee_id)->first();
            $reporting_employee_id=$this->report_employee_id;
            if($reporting_employee_id){
                $reportingEmployee=User::where('employee_id',$reporting_employee_id)->first();
                if($reportingEmployee){
                    $previousNotification=AcrNotification::where('employee_id',$reportingEmployee->employee_id)
                    ->where('acr_id',$this->id)
                    ->where('through',1)
                    ->where('notification_type',2)
                    ->orderBy('notification_on','DESC')->first();

                    if(!$previousNotification){
                        Mail::to($reportingEmployee)
                        ->cc($acruser)
                        ->send(new AcrSumittedMail($this,$reportingEmployee));

                        $data=[
                        'employee_id'=>$reportingEmployee->employee_id,
                        'acr_id'=>$this->id,
                        'notification_on'=>now(),
                        'through'=>1,
                        'notification_type'=>2,
                        'notification_no'=>1
                        ];
                        AcrNotification::create($data);
                    }
                }
            }
        Log::info("out submitNotification $this->id");

    }


    
}
