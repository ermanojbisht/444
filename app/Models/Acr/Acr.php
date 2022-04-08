<?php

namespace App\Models\Acr;

use App\Helpers\Helper;
use App\Mail\Acr\AcrSumittedMail;
use App\Models\Acr\AcrNotification;
use App\Models\Acr\AcrType;
use App\Models\Acr\Leave;
use App\Models\Employee;
use App\Models\Office;
use App\Models\User;
use App\Notifications\Acr\AcrSubmittedNotification;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Log;

class Acr extends Model
{
    /**
     * @var string
     */
    protected $table = 'hrms.acrs';
    protected $connection='mysqlhrms';

    /**
     * @var array
     */
    protected $fillable = [
        'employee_id', 'acr_type_id', 'office_id', 'from_date', 'to_date', 
        'good_work', 'difficultie', 'appreciations', 'submitted_at',
        'report_employee_id', 'review_employee_id', 'accept_employee_id',
        'is_active', 'appraisal_note_1', 'appraisal_note_2', 'appraisal_note_3',
        'professional_org_membership', 'property_filing_return_at', 'report_duration_lapsed',
        'review_duration_lapsed', 'accept_duration_lapsed',
        'report_no', 'report_on', 'report_remark',
        'review_no', 'review_on', 'review_remark',
        'accept_no', 'accept_on', 'accept_remark','is_defaulter',  'old_accept_no','final_accept_remark','missing'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'from_date', 'to_date', 'property_filing_return_at', 'submitted_at', 'report_on', 'review_on', 'accept_on'
    ];

    public static function boot() {
        parent::boot();
        self::deleting(function($acr) { // before delete() method call this

            $acr->fillednegativeparameters()->each(function($item) {
                $item->delete(); //
             });

             $acr->personalAttributes()->each(function($item) {
                $item->delete(); //
             });

             $acr->appraisalOfficerRecords()->each(function($item) {
                $item->delete(); //
             });

             $acr->filledparameters()->each(function($item) {
                $item->delete(); //
             });

             $acr->appreciations()->each(function($item) {
                $item->delete(); //
             });

             $acr->notifications()->each(function($item) {
                $item->delete(); //
             });

             if($acr->rejectionDetail){
                $acr->rejectionDetail->delete();
             }

             $acr->deletePdfFile();
             // do the rest of the cleanup...
        });

    }

    public function scopePeriodBetweenDates($query, array $dates)
    {
        $start = ($dates[0] instanceof Carbon) ? $dates[0] : Carbon::parse($dates[0]);
        $end   = ($dates[1] instanceof Carbon) ? $dates[1] : Carbon::parse($dates[1]);

        return $query->whereBetween('from_date', [
            $start->startOfDay(),
            $end->endOfDay()
        ])->whereBetween('to_date', [
            $start->startOfDay(),
            $end->endOfDay()
        ]);
    }


    public function scopeInYear($query, int $year)
    {
        return $this->scopePeriodBetweenDates($query,[$year.'-04-01',($year+1).'-03-31']);
    }

    /**
     * @return mixed
     */
    public function acrMasterParameters()
    {
        return $this->hasMany(AcrMasterParameter::class, 'acr_type_id', 'acr_type_id');
    }

    /**
     * @return mixed
     */
    public function type()
    {
        return $this->belongsTo(AcrType::class, 'acr_type_id', 'id');
    }

    /**
     * @return mixed
     */
    public function getTypeNameAttribute()
    {
        if ($this->type) {
            return $this->type->description;
        }

        return 'Defaulter\'s ACR';
    }

    /**
     * @return mixed
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    /**
     * @return mixed
     */
    public function personalAttributes()
    {
        return $this->hasMany(AcrPersonalAttribute::class);
    }

    /**
     * at what level acr is , submit means acr is submitted and reporting is pending
     * @param  $query
     * @param  $value
     * @return mixed
     */
    public function scopeLevel($query, $value = 'submit')
    {
        $query = $query->whereNotNull('report_employee_id')->whereNotNull('review_employee_id')->whereNotNull('accept_employee_id')->whereNotNull('submitted_at')->whereIsActive(1);
        switch ($value) {
            case 'submit':
                return $query->whereNull('report_on')
                    ->orderBy('submitted_at');
                break;
            case 'report':
                return $query->whereNull('review_on')
                    ->whereNotNull('report_on')
                    ->orderBy('report_on');
                break;
            case 'review':
                return $query->whereNull('accept_on')
                    ->whereNotNull('review_on')
                    ->orderBy('review_on');
                break;
            case 'accept':
                return $query->whereNotNull('accept_on')
                    ->orderBy('accept_on');
                break;
        }
    }

    /**
     * @param $scope
     * @param $attributes
     */
    public function isScope($scope, ...$attributes)
    {
        return static::$scope(...$attributes)->where($this->getKeyName(), $this->getKey())->exists();
    }

    /**
     * The roles that belong to the Acr
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function appraisalOfficers()
    {


        return $this->belongsToMany(Employee::class, env('DB_DATABASE_HRMS', 'hrms').'.appraisal_officers', 'acr_id', 'employee_id')
            ->withPivot('appraisal_officer_type', 'from_date', 'to_date', 'is_due');
    }

    /**
     * @return mixed
     */
    public function appraisalOfficerRecords()
    {
        return $this->hasMany(AppraisalOfficer::class);
    }


    public function appreciations()
    {
        return $this->hasMany(Appreciation::class);
    }

    public function notifications()
    {
        return $this->hasMany(AcrNotification::class);
    }

    /**
     * @param $start
     * @param $end
     */
    public function checkisDateInBetween($start, $end)
    {
        $acrPeriodStartDate = $this->from_date;
        $acrPeriodEndDate = $this->to_date;
        //$start<$end //return with msg "start/from date can not be less then end/to date"
        if ($start > $end) {
            return ['status' => false, 'msg' => 'From date '.$start->format('d M y').' can not be less then To date'.$end->format('d M y')];
        }
        //$start,$end within $acrPeriodStartDate,$acrPeriodEndDate //start and end date should be within ACR period as mentioned by you

        if (!$start->betweenIncluded($acrPeriodStartDate, $acrPeriodEndDate)) {
            return ['status' => false, 'msg' => 'From date '.$start->format('d M y').' is beyond the ACR period ('.$acrPeriodStartDate->format('d M y').' - '.$acrPeriodEndDate->format('d M y').' )'];
        }

        if (!$end->betweenIncluded($acrPeriodStartDate, $acrPeriodEndDate)) {
            return ['status' => false, 'msg' => 'To date '.$end->format('d M y').' is beyond the ACR period ('.$acrPeriodStartDate->format('d M y').' - '.$acrPeriodEndDate->format('d M y').' )'];
        }

        return ['status' => true, 'msg' => ''];
    }

    /**
     * @param $start
     * @param $end
     * @param $appraisal_officer_type
     */
    public function checkPeriodInput($start, $end, $appraisal_officer_type)
    {
        $this->checkisDateInBetween($start, $end);

        //same officer level it should not intersect // period overlaps with previos line at record no
        $otherRecords = $this->appraisalOfficerRecords()->where('appraisal_officer_type', $appraisal_officer_type)->get();
        foreach ($otherRecords as $record) {
            $recordPeriod = CarbonPeriod::create($record->from_date, $record->to_date);
            if ($recordPeriod->overlaps($start, $end)) {
                return ['status' => false, 'msg' => 'Given period ('.$start->format('d M y').' - '.
                    $end->format('d M y').') intersect with period ( '.
                    $record->from_date->format('d M y').' - '.$record->to_date->format('d M y').
                    ' ) in our record Employee ID = '.$record->employee_id];
            }
            //if old record has already period for 90 days then revert
            if ($recordPeriod->count() >= 90) {
                return ['status' => false, 'msg' => 'Period ( '.$record->from_date->format('d M y').' - '.
                    $record->to_date->format('d M y').' ) in our Employee ID='.$record->employee_id.
                    ' already has '.$recordPeriod->count().' days'];
            }
        }

        return ['status' => true, 'msg' => ''];
    }

    /**
     * @param  $appraisal_officer_type
     * @return mixed
     */
    public function hasAppraisalOfficer($appraisal_officer_type)
    {
        return $this->appraisalOfficers()->wherePivot('appraisal_officer_type', $appraisal_officer_type)->count();
    }

    public function isSubmitted()
    {
        return ($this->submitted_at) ? true : false;
    }

    /**
     * @param $appraisal_officer_type
     */
    public function updateIsDue($appraisal_officer_type)
    {
        $records = $this->appraisalOfficerRecords()->whereAppraisalOfficerType($appraisal_officer_type)->orderBy('from_date')->get();
        $responsible_employee_id = '';
        foreach ($records as $key => $record) {
            //Log::info(print_r($record, true));

            if ($record->from_date->diffInDays($record->to_date) + 1 >= 90 && $responsible_employee_id === '') {
                $record->is_due = 1;
                $responsible_employee_id = $record->employee_id;
            } else {
                if ($record->to_date == $this->to_date) {
                    //if last record to_date is same as period last date then although acr is not due but still responsible officer will be last person
                    $record->is_due = 0;
                    $responsible_employee_id = $record->employee_id;
                } else {
                    $record->is_due = 0;
                }
            }

            $record->save();
        }
        $this->update([config('acr.basic.acrProcessFields')[$appraisal_officer_type] => $responsible_employee_id]);
    }

    /**
     * @return mixed
     */
    public function filledparameters()
    {
        return $this->hasMany(AcrParameter::class);
    }

    /**
     * @return mixed
     */
    public function fillednegativeparameters()
    {
        return $this->hasMany(AcrNegativeParameter::class);
    }

    /**
     * @return mixed
     */
    public function type1RequiremntsWithFilledData()
    {
        $filledparameters = $this->filledparameters()->get()->keyBy('acr_master_parameter_id');
        $requiredParameters = $this->acrMasterParameters()->where('type', 1)->get();
        $requiredParameters->map(function ($row) use ($filledparameters) {
            if (isset($filledparameters[$row->id])) {
                $row->user_target = $filledparameters[$row->id]->user_target;
                $row->user_achivement = $filledparameters[$row->id]->user_achivement;
                $row->status = $filledparameters[$row->id]->status;
                $row->applicable = $filledparameters[$row->id]->is_applicable;
                $row->reporting_marks = $filledparameters[$row->id]->reporting_marks;
                $row->reviewing_marks = $filledparameters[$row->id]->reviewing_marks;
            } else {
                $row->user_target = $row->user_achivement = $row->status = 0;
            }

            return $row;
        });

        return $requiredParameters->groupBy('config_group');
    }

    /**
     * @return mixed
     */
    public function type2RequiremntsWithFilledData()
    {
        $filledparameters = $this->filledparameters()->get()->keyBy('acr_master_parameter_id');
        $requiredParameters = $this->acrMasterParameters()->where('type', 0)->get();
        $requiredParameters->map(function ($row) use ($filledparameters) {
            if (isset($filledparameters[$row->id])) {
                $row->reporting_marks = $filledparameters[$row->id]->reporting_marks;
                $row->reviewing_marks = $filledparameters[$row->id]->reviewing_marks;
            } else {
                $row->reporting_marks = $row->reviewing_marks = 0;
            }

            return $row;
        });

        return $requiredParameters;
        //return $requiredParameters->groupBy('config_group');
    }

    /**
     * @return mixed
     */
    public function negative_groups()
    {
        $require_negative_parameters = $this->acrMasterParameters()->where('type', 0)->get()->keyBy('id');
        $filled_negative_parameters = $this->fillednegativeparameters()->get()->groupBy('acr_master_parameter_id');
        $require_negative_parameters->map(function ($row) use ($filled_negative_parameters) {
            if (isset($filled_negative_parameters[$row->id])) {
                $row->user_filled_data = $filled_negative_parameters[$row->id];
            } else {
                $row->user_filled_data = [];
            }

            return $row;
        });

        return $require_negative_parameters->groupBy('config_group');
    }

    public function getIsAcknowledgedAttribute()
    {
        return $this->is_defaulter==2;
    }

    public function getIsbyhrAttribute()
    {
        return $this->is_defaulter==1;
    }

    /**
     * @return mixed
     */
    public function peronalAttributeSWithMasterData()
    {
        $personalAttributes = $this->personalAttributes()->get()->keyBy('personal_attribute_id');

        return AcrMasterPersonalAttributes::all()->map(function ($row) use ($personalAttributes) {
            if (isset($personalAttributes[$row->id])) {
                $row->reporting_marks = $personalAttributes[$row->id]->reporting_marks;
                $row->reviewing_marks = $personalAttributes[$row->id]->reviewing_marks;
            } else {
                $row->reporting_marks = $row->reviewing_marks = 0;
            }

            return $row;
        });
    }

    public function getPdfFilePathAttribute()
    {
        return 'acr/'.$this->employee_id.'/'.$this->id.'.pdf';
    }

    /**
     * @return mixed
     */
    public function getGradeAttribute()
    {
        $marks = $this->accept_no;
        switch (true) {
            case ($marks > 80.0):
                {
                    $grades = 'Out Standing';
                    break;
                }
            case ($marks > 60.0 && $marks <= 80.0):
                {
                    $grades = 'Very Good';
                    break;
                }
            case ($marks > 40.0 && $marks <= 60.0):
                {
                    $grades = 'Good';
                    break;
                }
            case ($marks > 20.0 && $marks <= 40.0):
                {
                    $grades = 'Satisfactory';
                    break;
                }
            case ($marks <= 20.0):
                {
                    $grades = 'Unsatisfactory';
                    break;
                }
            default:{
                    $grades = 'Unknown / Not decided';
                    break;
                }
        }

        return $grades;
    }

    public function getIsSinglePageAttribute()
    {
        return in_array($this->acr_type_id, config('acr.basic.acrWithoutProcess'));
    }

    public function getIsTwoStepAttribute()
    {
        return ($this->acr_type_id==30);
    }

    public function getIsLegacyAttribute()
    {
        return ($this->acr_type_id==0);
    }

    public function getIsDurationMatchesAttribute()
    {
        $appraisalOfficerRecords=$this->appraisalOfficerRecords()->get();
        $days=0;
        $appraisalOfficerRecords->map(function($record) use (&$days){
           $days+= $record->from_date->diffInDays($record->to_date)+1;          
        });

        if($days===0){ return false; }      

        $factor=($this->isTwoStep)?2:3;
        
        return ($this->from_date->diffInDays($this->to_date)) +1 ===($days/$factor);
    }

    public function getPdfFullFilePathAttribute()
    {
        return \Storage::disk('public')->path($this->pdf_file_path);
    }

    public function isFileExist()
    {
        return \Storage::disk('public')->exists($this->pdf_file_path);
    }

    /**
     * @return mixed
     */
    public function submitUser()
    {
        return $this->userOnBasisOfDuty('submit');
    }

    /**
     * @return mixed
     */
    public function reportUser()
    {
        return $this->userOnBasisOfDuty('report');
    }

    /**
     * @return mixed
     */
    public function reviewUser()
    {
        return $this->userOnBasisOfDuty('review');
    }

    /**
     * @return mixed
     */
    public function acceptUser()
    {
        return $this->userOnBasisOfDuty('accept');
    }

    /**
     * @param $dutyType
     */
    public function userOnBasisOfDuty($dutyType)
    {
        $target_employee_field = config('acr.basic.duty')[$dutyType]['targetemployee'];
        $target_employee_id = $this->$target_employee_field;
        if ($target_employee_id) {
            return User::where('employee_id', $target_employee_id)->first();
        }

        return false;
    }

    /**
     * @param $pdf
     * @param $forced
     */
    public function createPdfFile($pdf, $forced = true)
    {
        //Log::info("in acr createPdfFile  ");
        //$fullpath=\Storage::disk('public')->path($this->pdf_file_path);
        if ($forced || (!$this->isFileExist())) {
            $path = $this->pdf_file_path;
            File::ensureDirectoryExists(dirname($this->pdfFullFilePath), $mode = 0775, $recursive = true);
            $this->deletePdfFile();
            $pdf->save(\Storage::disk('public')->path($path));
        }
    }

    public function deletePdfFile()
    {
        if ($this->isFileExist()) {
            \Storage::disk('public')->delete($this->pdf_file_path);
        }
    }

    public function acknowledgedNotification($msg)
    {
        $this->mailNotificationFor($targetDutyType = 'acknowledge', $notification_type = 1,$msg);
    }

    public function submitNotification()
    {
        $this->mailNotificationFor($targetDutyType = 'report', $notification_type = 2);
    }

    public function reportNotification()
    {
        $this->mailNotificationFor($targetDutyType = 'review', $notification_type = 3);
    }

    public function reviewNotification()
    {
        if($this->isTwoStep){
            $this->acceptNotification();
        }else{
            $this->mailNotificationFor($targetDutyType = 'accept', $notification_type = 4);
    }
    }

    public function acceptNotification()
    {
        //now target is submit beacause it's just back to user
        $this->mailNotificationFor($targetDutyType = 'submit', $notification_type = 5);
    }

    public function correctnoticeNotification()
    {
        //now target is submit beacause it's just back to user
        $this->mailNotificationFor($targetDutyType = 'correctnotice', $notification_type = 7);
    }



    public function rejectNotification()
    {
        // on reject targetduty is againsubmit or rejecr itself
        $this->mailNotificationFor($targetDutyType = 'reject', $notification_type = 6);
    }

    /**
     * @param $targetDutyType
     * @param $notification_type
     */
    public function mailNotificationFor($targetDutyType, $notification_type,$msg=false)
    {
        $targetEmployee = $this->userOnBasisOfDuty($targetDutyType);
        if ($targetEmployee) {
            //check if already notified
            $previousNotification = AcrNotification::where('employee_id', $targetEmployee->employee_id)
                ->where('acr_id', $this->id)
                ->where('through', 1) //for mail , may be 2 for sms
                ->where('notification_type', $notification_type) //2=for report 7=correctnotice 1=acknowledge
                ->orderBy('notification_on', 'DESC')->first();

            if (!$previousNotification) {
                $mail = Mail::to($targetEmployee);
                if ($targetEmployee->chat_id > 90000) {
                    $response = $targetEmployee->notify(new AcrSubmittedNotification($this, $targetEmployee, $targetDutyType,$msg));
                }

                switch ($targetDutyType) {
                    case 'acknowledge':
                        //on acknowledge event  , filling and further process is targeted
                        //employee is as target
                        /*if(Auth::user()){
                            $mail->cc(Auth::user()); //cc to HR on error we may remove it
                        }*/
                        break;
                    case 'report':
                        //on submit event  , report is targeted
                        //reportUser is as target
                        $mail->cc($this->submitUser());
                        break;
                    case 'review':
                        //on report event , review is targeted
                        //review is as target
                        $mail->cc($this->userOnBasisOfDuty('report'));
                        //$mail->cc($this->submitUser());
                        break;
                    case 'accept':
                        //on review event , accept is targeted
                        //accept user is as target
                        $mail->cc($this->userOnBasisOfDuty('review'));
                        //$mail->cc($this->userOnBasisOfDuty('report'));
                        //$mail->cc($this->submitUser());
                        break;
                    case 'correctnotice':
                        //on review event , accept is targeted
                        //accept user is as target
                        //$mail->cc($this->userOnBasisOfDuty('review'));
                        //$mail->cc($this->userOnBasisOfDuty('report'));
                        //$mail->cc($this->submitUser());
                        break;

                    case 'submit':
                        //on accept event , submituser is targeted
                        //$mail->cc($this->userOnBasisOfDuty('review'));
                        if($this->isTwoStep){
                            $mail->cc($this->userOnBasisOfDuty('review'));
                        }else{
                            $mail->cc($this->userOnBasisOfDuty('accept'));
                        }
                        break;

                    case 'reject':
                        //on reject event , submituser is targeted
                        //$mail->cc($this->userOnBasisOfDuty('review'));
                        //$mail->cc($this->userOnBasisOfDuty('report'));
                        $ccmails=[];
                        if($this->userOnBasisOfDuty('report')){$ccmails[]=$this->userOnBasisOfDuty('report');}
                        if($this->userOnBasisOfDuty('review')){$ccmails[]=$this->userOnBasisOfDuty('review');}
                        if($this->userOnBasisOfDuty('accept')){$ccmails[]=$this->userOnBasisOfDuty('accept');}
                        if(count($ccmails)>0){
                            $mail->cc($ccmails);
                        }
                        break;
                }
                Log::info("targetEmployee1111 = ".print_r($targetEmployee,true));
                
                $mail->send(new AcrSumittedMail($this, $targetEmployee, $targetDutyType,$msg));
                //$msg is false in other cases except acknowledgedNotification

                $data = [
                    'employee_id' => $targetEmployee->employee_id,
                    'acr_id' => $this->id,
                    'notification_on' => now(),
                    'through' => 1,
                    'notification_type' => $notification_type,
                    'notification_no' => 1
                ];
                AcrNotification::create($data);
            }
        }
    }

    /**
     * @return mixed
     */
    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    /**
     * @param  $Officer_type
     * @return mixed
     */
    public function report_review_Accept_officers($Officer_type)
    {
        return $this->belongsTo(Employee::class, $Officer_type.'_employee_id', 'id')->first();
    }

    public function firstFormData()
    {
        $employee = Employee::findOrFail($this->employee_id);
        $appraisalOfficers = $this->appraisalOfficers()->get();

        $officeWithParentList = Office::ancestorsAndSelf($this->office_id)->pluck('name', 'office_type')->reverse()->toArray();

        if (count($officeWithParentList) > 1) {
            array_pop($officeWithParentList);
        }

        $leaves = $this->leaves();
        $appreciations = Appreciation::where('acr_id', $this->id)->get();

        $inbox = Acr::whereNotNull('submitted_at')->where('report_employee_id', $this->employee_id)
            ->where('is_active', 1)->whereNull('report_on')->get();

        $reviewed = Acr::whereNotNull('submitted_at')->where('review_employee_id', $this->employee_id)
            ->where('is_active', 1)->whereNotNull('report_on')->whereNull('review_on')->get();
        $accepted = Acr::whereNotNull('submitted_at')->where('accept_employee_id', $this->employee_id)
            ->where('is_active', 1)->whereNotNull('report_on')->whereNotNull('review_on')->whereNull('accept_on')->get();

        return [$employee, $appraisalOfficers, $leaves, $appreciations, $inbox, $reviewed, $accepted, $officeWithParentList];
    }

    /**
     * @param $dutyType
     */
    public function updateEsclationFor($dutyType)
    {
        if($dutyType=='accept' && $this->isTwoStep){
            //no need to run third step
        }else{

            $duty = config('acr.basic.duty')[$dutyType];
            $duty_duration_lapsed_field = $dutyType.'_duration_lapsed';
            $duty_triggerDate = $duty['triggerDate'];
            $this->$duty_duration_lapsed_field = round($this->$duty_triggerDate->diffInDays(now(), false) / $duty['period'] * 100, 0);
            if ($this->$duty_triggerDate->diffInDays(now(), false) > $duty['period']) {
                $finalDateField = $dutyType.'_on';
                $this->$finalDateField = now();
            }
            $this->save();
        }
    }

    public function checkSelfAppraisalFilled()
    {
        // check table 1
        if(!$this->is_defaulter){

            if ($this->isSinglePage) {
                if (!$this->good_work) {
                    return ['status' => false, 'msg' => 'Self-Appraisal Not Filled for this ACR '];
                }
            } else {
                if (AcrParameter::where('acr_id', $this->id)->count() == 0) {
                    return ['status' => false, 'msg' => 'Self-Appraisal Not Filled for this ACR '];
                }

            }
        }

        return ['status' => true, 'msg' => ''];
    }

    public function permissionForPdf()
    {
        $user = Auth::user();

        if ($user->hasPermissionTo(['acr-special']) || ($user->employee_id == $this->employee_id)) {
            return true;
        }

        if ($user->employee_id == $this->report_employee_id && (!$this->report_on)) {
            return true;
        }

        if ($user->employee_id == $this->review_employee_id && (!$this->review_on)) {
            return true;
        }

        if ($user->employee_id == $this->accept_employee_id && (!$this->accept_on)) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function rejectionDetail()
    {
        return $this->hasOne(AcrRejection::class);
    }

    /**
     * @return mixed
     */
    public function rejectUser()
    {
        if ($this->rejectionDetail) {
            $user = User::where('employee_id', $this->rejectionDetail->employee_id)->first();
            if ($user) {
                return $user;
            }
        }

        return (new User);
    }

    /**
     * @return mixed
     */
    public function status()
    {
       $statusNo=$this->statusNo();       
       switch ($statusNo) {
           case 1:
               return 'New Created on '.$this->created_at->format('d M Y');
               break;
           case 2:
               return 'Created by HR on '.$this->created_at->format('d M Y');
               break;
           case 3:
               return 'Acknowledged on '.$this->updated_at->format('d M Y');
               break;
            case 4:
               return 'Submitted on '.$this->submitted_at->format('d M Y');
               break;
            case 5:
               return 'Reported on '.$this->report_on->format('d M Y');
               break;
            case 6:
               return 'Reviewed on '.$this->review_on->format('d M Y');
               break;
            case 7:
               return 'Accepted on '.$this->accept_on->format('d M Y');
               break;
            case 8:
               return 'Corrected ';
            case 9:
               return 'Legacy Data  filled on '.$this->created_at->format('d M Y');
               break;
            case 100:
               $rejection = $this->rejectionDetail()->first();
               return'Rejected by '.$this->rejectUser()->shriName.' on '.$rejection->created_at->format('d M Y'); 
               break;           
       }
    }

    public function statusNo()
    {
        if ($this->is_active == 0){
            return 100;
        }
        if ($this->acr_type_id==0) {
            return 9;
        }
        if ($this->old_accept_no) {
            return 8;
        }
        if ($this->accept_on) {
            return 7;
        }
        if ($this->review_on) {
            return 6;
        }
        if ($this->report_on) {
            return 5;
        }
        if ($this->submitted_at) {
            return 4;
        }
        if ($this->is_defaulter == 2) {
            return 3;
        }
        if ($this->is_defaulter == 1) {
            return 2;
        }
        return 1;        
    }

    public function status_bg_color()
    {
        if ($this->is_active == 0) {
            return 'bg-danger bg-gradient ';
        } else if ($this->accept_on) {
            return 'bg-success bg-gradient  ';
        } else if ($this->review_on) {
            return 'bg-info bg-gradient ';
        } else if ($this->report_on) {
            return 'bg-primary bg-gradient ';
        } else if ($this->submitted_at) {
            return 'bg-info bg-gradient ';
        } else {
            return ' bg-info bg-gradient';
        }
    }

    /**
     * @return mixed
     */
    public function analysisForAlert()
    {
        $result = ['name' => $this->employee->shriName, 'employee_id' => $this->employee_id, 'target_employee_id' => '', 'pending_process' => '', 'percentage_period' => ''];

        $duties = ['report', 'review', 'accept'];
        foreach ($duties as $key => $duty) {
            $duration_lapsed_field = $duty.'_duration_lapsed';
            $targetEmployee_field = $duty.'_employee_id';
            if ($this->$duration_lapsed_field > 0) {
                $targetEmployee = $this->$targetEmployee_field;
                $targetProcess = $duty;
                $lapsedPeriod = $this->$duration_lapsed_field;
            }
        }

        $result['target_employee_id'] = $targetEmployee;
        $result['pending_process'] = $targetProcess;
        $result['percentage_period'] = $lapsedPeriod;

        return $result;
    }

     // todo these function to be shifted in ACR Controller
    public function getUserParameterData($paramId)
    {
        $AcrMasterParameter =  AcrMasterParameter::where('id', $paramId)->first();
        $AcrParameter =  $this->filledparameters()->where('acr_master_parameter_id', $paramId)->first();

        $text = [];
        $text[] = "<p class='fw-semibold bg-warning p-1'>" . $AcrMasterParameter->description . "</p>";
        if (isset($AcrParameter)) {
            if ($AcrParameter->is_applicable == 1) {
                if ($AcrMasterParameter->config_group == 1001) {
                    $text[] = "<p class='fw-semibold'>";
                    if(empty($AcrParameter->user_achivement)){
                        $text[] = "<span class='text-danger'> not filled </span>";
                    }else{
                        $text[] = "<span class='text-success'>".$AcrParameter->user_achivement." ".$AcrMasterParameter->unit."</span>";
                    }
                    $text[] = "</span> Achivement Against Target <span class='text-danger'>";
                    if(empty($AcrParameter->user_target)){
                        $text[] = "<span class='text-danger'> not filled </span>";
                    }else{
                        $text[] = "<span class='text-success'>".$AcrParameter->user_target." ".$AcrMasterParameter->unit."</span>";
                    }
                    $text[] = "</p>";
                } elseif ($AcrMasterParameter->config_group == 1002) {
                    $text[] = "<p class='fw-semibold text-success'> status : "
                             . $AcrParameter->status 
                             . "</p>";
                } else {
                    $text[] = "<p class='fw-semibold text-danger'> ....... </p>";
                }
            } elseif ($AcrParameter->is_applicable == 0) {
                $text[] = "<p class='fw-semibold text-danger'> User Selected Not Applicable for This Parameter</p>";
            } else {
                $text[] = "<p class='fw-semibold text-danger'> ....... </p>";
            }
        } else {
            $text[] = "<p class='fw-semibold text-danger'> User not Filled any Data</p>";
        }

        return $text;
    }

    public function getUserNegativeParameterData($paramId)
    {
       $text ='';

        $AcrMasterParameter =  AcrMasterParameter::where('id', $paramId)->first();

        $groupId = $AcrMasterParameter->config_group;

        $AcrParameter =  $this->fillednegativeparameters()->where('acr_master_parameter_id', $paramId)->get();
        $text = $text."<p class='fw-semibold bg-warning p-1'>" . $AcrMasterParameter->description . "</p>";
       
        if (isset($AcrParameter)) {
            if ($groupId > 2000 && $groupId < 3000) {
                $text = $text.'<table class="table table-sm table-bordered"><thead><tr>';
                foreach (config('acr.group')[$groupId]['columns'] as $key => $columns) {
                    $text = $text.'<th class="text-info align-middle text-center small">' . $columns['text'] . '</th>';
                }
                $text = $text.'</tr></thead><tbody>';
                $n = 0;
                foreach ($AcrParameter as $Parameter) {
                    $text = $text.'<tr>';
                    foreach (config('acr.group')[$groupId]['columns'] as $key => $columns) {
                        if ($columns['input_type'] === false) {
                            $n = $n + 1;
                            $text = $text.'<td class="text-center small">'.$n.') </td>';
                        } else {
                            $text = $text.'<td class="text-center small ">' . $Parameter[$columns['input_name']] . '</td>';
                        }
                    }
                    $text = $text."</tr>";
                }
                $text = $text."</tbody></table>";
            } elseif ($groupId > 3000) {
                foreach ($AcrParameter as $Parameter) {
                    foreach (config('acr.group')[$groupId]['columns'] as $key => $columns) {
                        $text = $text
                                ."<p>"
                                .$columns['text']
                                ."-- <span class='text-info'>"
                                .$Parameter[$columns['input_name']]
                                ."</span></p>";
                    }
                }
            }
        } else {
            $text = $text."<p class='fw-semibold text-danger'> User not Filled any Data</p>";
        }
        return $text;
    }


    public function isAcrDuetoLoggedUserfor($jobType){
    
        switch ($jobType) {
            case 'review':
                $appraisal_officer_type = 2;
                break;
             case 'accept':
                $appraisal_officer_type = 3;
                break;
             case 'report':
                $appraisal_officer_type = 1;
                break;
        }
        return $this->appraisalOfficerRecords()->where('employee_id',Auth::user()->employee_id)->where('appraisal_officer_type', $appraisal_officer_type)->first()->is_due;

    }
    
    public function getFinancialYearAttribute()
    {
       return Helper::currentFy($this->from_date->year, $this->from_date->month);
    }

    public function leaves()
    {
        $leaves = Leave::where('employee_id', $this->employee_id)
        ->where('from_date','<=',$this->to_date)
        ->where('to_date','>=',$this->from_date)
        ->get();
        
        $acr=$this;

        return $leaves->map(function($row) use($acr){
            if($row->from_date<$acr->from_date){
               $row->from_date= $acr->from_date;
            }
            if($row->to_date>$acr->to_date){
               $row->to_date= $acr->to_date;
            }
            return $row;
        });
    }

}
