<?php

namespace App\Models\Acr;

use  App\Models\Acr\AcrType;
use App\Mail\Acr\AcrSumittedMail;
use App\Models\Acr\AcrNotification;
use App\Models\Employee;
use App\Models\Office;
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
use File;
use Auth;

class Acr extends Model
{
    protected $table = 'acrs';

    protected $fillable = [
        'employee_id', 'acr_type_id', 'office_id', 'from_date', 'to_date', 'prpoerty_return_date',
        'good_work', 'difficultie', 'appreciations', 'submitted_at',
        'report_employee_id', 'review_employee_id', 'accept_employee_id',
        'is_active', 'appraisal_note_1', 'appraisal_note_2', 'appraisal_note_3',
        'professional_org_membership', 'property_filing_return_at', 'report_duration_lapsed',
        'review_duration_lapsed', 'accept_duration_lapsed',
        'report_no', 'report_on', 'report_remark',
        'review_no', 'review_on', 'review_remark',
        'accept_no', 'accept_on', 'accept_remark'
    ];


    protected $dates = [
        'from_date', 'to_date', 'property_filing_return_at', 'submitted_at', 'report_on', 'review_on', 'accept_on'
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

    public function personalAttributes()
    {
        return $this->hasMany(AcrPersonalAttribute::class);
    }


    public function scopeLevel($query, $value = 'submit')
    {
        $query = $query->whereNotNull('report_employee_id')->whereNotNull('review_employee_id')->whereNotNull('accept_employee_id')->whereNotNull('submitted_at');
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
                    ->orderBy('review_on');
                break;
        }
    }

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
        return $this->belongsToMany(Employee::class, 'appraisal_officers', 'acr_id', 'employee_id')
            ->withPivot('appraisal_officer_type', 'from_date', 'to_date', 'is_due');
    }

    public function appraisalOfficerRecords()
    {
        return $this->hasMany(AppraisalOfficer::class);
    }


    public function checkisDateInBetween($start, $end)
    {
        $acrPeriodStartDate = $this->from_date;
        $acrPeriodEndDate = $this->to_date;
        //$start<$end //return with msg "start/from date can not be less then end/to date"
        if ($start > $end) {
            return ['status' => false, 'msg' => 'From date ' . $start->format('d M y') . ' can not be less then To date' . $end->format('d M y')];
        }
        //$start,$end within $acrPeriodStartDate,$acrPeriodEndDate //start and end date should be within ACR period as mentioned by you

        if (!$start->betweenIncluded($acrPeriodStartDate, $acrPeriodEndDate)) {
            return ['status' => false, 'msg' => 'From date ' . $start->format('d M y') . ' is beyond the ACR period (' . $acrPeriodStartDate->format('d M y') . ' - ' . $acrPeriodEndDate->format('d M y') . ' )'];
        }

        if (!$end->betweenIncluded($acrPeriodStartDate, $acrPeriodEndDate)) {
            return ['status' => false, 'msg' => 'To date ' . $end->format('d M y') . ' is beyond the ACR period (' . $acrPeriodStartDate->format('d M y') . ' - ' . $acrPeriodEndDate->format('d M y') . ' )'];
        }

        return ['status' => true, 'msg' => ''];
    }



    public function checkPeriodInput($start, $end, $appraisal_officer_type)
    {
        $this->checkisDateInBetween($start, $end);

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

            //Log::info(print_r($record, true));

            if ($record->from_date->diffInDays($record->to_date) >= 90 && $responsible_employee_id === '') {
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


    public function peronalAttributeSWithMasterData()
    {
        $personalAttributes = $this->personalAttributes()->get()->keyBy('personal_attribute_id');

        return  AcrMasterPersonalAttributes::all()->map(function ($row) use ($personalAttributes) {
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
        return 'acr/' . $this->employee_id . '/' . $this->id . '.pdf';
    }

    public function getGradeAttribute()
    {
        $marks = $this->accept_no;
        switch (true) {
            case ($marks > 80.0): {
                    $grades = 'Out Standing';
                    break;
                }
            case ($marks > 60.0 &&  $marks <= 80.0): {
                    $grades = 'Very Good';
                    break;
                }
            case ($marks > 40.0 &&  $marks <= 60.0): {
                    $grades = 'Good';
                    break;
                }
            case ($marks > 20.0 &&  $marks <= 40.0): {
                    $grades = 'Satisfactory';
                    break;
                }
            case ($marks <= 20.0): {
                    $grades = 'Unsatisfactory';
                    break;
                }
            default: {
                    $grades = 'Unknown / Not decided';
                    break;
                }
        }
        return $marks;
    }

    public function getPdfFullFilePathAttribute()
    {
        return \Storage::disk('public')->path($this->pdf_file_path);
    }



    public function isFileExist()
    {
        return \Storage::disk('public')->exists($this->pdf_file_path);
    }

    public function submitUser()
    {
        return $this->userOnBasisOfDuty('submit');
    }

    public function reportUser()
    {
        return $this->userOnBasisOfDuty('report');
    }

    public function reviewUser()
    {
        return $this->userOnBasisOfDuty('review');
    }

    public function acceptUser()
    {
        return $this->userOnBasisOfDuty('accept');
    }

    public function userOnBasisOfDuty($dutyType)
    {
        $target_employee_field = config('acr.basic.duty')[$dutyType]['field'];
        $target_employee_id = $this->$target_employee_field;
        if ($target_employee_id) {
            return User::where('employee_id', $target_employee_id)->first();
        }
        return false;
    }



    public function createPdfFile($pdf, $forced = true)
    {
        //Log::info("in acr createPdfFile  ");
        //$fullpath=\Storage::disk('public')->path($this->pdf_file_path);
        if ($forced || (!$this->isFileExist())) {
            $path = $this->pdf_file_path;
            File::ensureDirectoryExists(dirname($this->pdfFullFilePath), $mode = 0755, $recursive = true);
            if ($this->isFileExist()) {
                \Storage::disk('public')->delete($path);
            }
            $pdf->save(\Storage::disk('public')->path($path));
        }
    }

    public function submitNotification()
    {
        $this->mailNotificationFor($targetDutyType = 'report', $notification_type = 2);

        /*$targetEmployee=$this->userOnBasisOfDuty($dutyType='submit');
        if ($targetEmployee) {
            //check if already notified
            $previousNotification = AcrNotification::where('employee_id', $targetEmployee->employee_id)
                ->where('acr_id', $this->id)
                ->where('through', 1)//for mail , may be 2 for sms
                ->where('notification_type', 2) //2=for report
                ->orderBy('notification_on', 'DESC')->first();

            if (!$previousNotification) {
                Mail::to($targetEmployee)
                    ->cc($this->submitUser())
                    ->send(new AcrSumittedMail($this, $targetEmployee));

                $data = [
                    'employee_id' => $targetEmployee->employee_id,
                    'acr_id' => $this->id,
                    'notification_on' => now(),
                    'through' => 1,
                    'notification_type' => 2,
                    'notification_no' => 1
                ];
                AcrNotification::create($data);
            }
        }*/
    }

    public function reportNotification()
    {
        $this->mailNotificationFor($targetDutyType = 'review', $notification_type = 3);
    }

    public function reviewNotification()
    {
        $this->mailNotificationFor($targetDutyType = 'accept', $notification_type = 4);
    }

    public function acceptNotification()
    {
        //now target is submit beacause it's just back to user
        $this->mailNotificationFor($targetDutyType = 'submit', $notification_type = 5);
    }

    public function mailNotificationFor($targetDutyType, $notification_type)
    {
        $targetEmployee = $this->userOnBasisOfDuty($targetDutyType);
        if ($targetEmployee) {
            //check if already notified
            $previousNotification = AcrNotification::where('employee_id', $targetEmployee->employee_id)
                ->where('acr_id', $this->id)
                ->where('through', 1) //for mail , may be 2 for sms
                ->where('notification_type', $notification_type) //2=for report
                ->orderBy('notification_on', 'DESC')->first();

            if (!$previousNotification) {
                $mail = Mail::to($targetEmployee);

                switch ($targetDutyType) {
                    case 'report':  //on submit event  , report is targeted
                        //reportUser is as target
                        $mail->cc($this->submitUser());
                        break;
                    case 'review': //on report event , review is targeted
                        //review is as target
                        $mail->cc($this->userOnBasisOfDuty('report'));
                        $mail->cc($this->submitUser());
                        break;
                    case 'accept': //on review event , accept is targeted
                        //accept user is as target
                        $mail->cc($this->userOnBasisOfDuty('review'));
                        $mail->cc($this->userOnBasisOfDuty('report'));
                        $mail->cc($this->submitUser());
                        break;

                    case 'submit': //on accept event , submituser is targeted
                        $mail->cc($this->userOnBasisOfDuty('review'));
                        $mail->cc($this->userOnBasisOfDuty('report'));
                        $mail->cc($this->userOnBasisOfDuty('accept'));
                        break;
                }

                $mail->send(new AcrSumittedMail($this, $targetEmployee, $targetDutyType));

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


    public function smsNotificationFor($mobileNo, $message)
    {
   
        $ch = curl_init('https://www.yousms.in/smsclient/api.php?');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "username=pwditcell&password=98993689&source=EICPWD&dmobile=". 
                    $mobileNo ."&message=" . $message);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $data = curl_exec($ch);
        return $data;
            
    }


    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function report_review_Accept_officers($Officer_type)
    {
        return $this->belongsTo(Employee::class, $Officer_type . '_employee_id', 'id')->first();
    }

    public function firstFormData()
    {
        $employee = Employee::findOrFail($this->employee_id);
        $appraisalOfficers =  $this->appraisalOfficers()->get();

        $leaves = Leave::where('acr_id', $this->id)->get();
        $appreciations = Appreciation::where('acr_id', $this->id)->get();

        $inbox = Acr::whereNotNull('submitted_at')->where('report_employee_id', $this->employee_id)
            ->where('is_active', 1)->whereNull('report_on')->get();

        $reviewed = Acr::whereNotNull('submitted_at')->where('review_employee_id', $this->employee_id)
            ->where('is_active', 1)->whereNotNull('report_on')->whereNull('review_on')->get();
        $accepted = Acr::whereNotNull('submitted_at')->where('accept_employee_id', $this->employee_id)
            ->where('is_active', 1)->whereNotNull('report_on')->whereNotNull('review_on')->whereNull('accept_on')->get();

        return [$employee, $appraisalOfficers, $leaves, $appreciations, $inbox, $reviewed, $accepted];
    }

    public function updateEsclationFor($dutyType)
    {
        $duty = config('acr.basic.duty')[$dutyType];
        $duty_duration_lapsed_field = $dutyType . '_duration_lapsed';
        $duty_triggerDate = $duty['triggerDate'];
        $this->$duty_duration_lapsed_field = round($this->$duty_triggerDate->diffInDays(now(), false) / $duty['period'] * 100, 0);
        if ($this->$duty_triggerDate->diffInDays(now(), false) > $duty['period']) {
            $finalDateField = $dutyType . '_on';
            $this->$finalDateField = now();
        }
        $this->save();
    }


    public function checkSelfAppraisalFilled()
    {
        // check table 1
        if (AcrParameter::where('acr_id', $this->id)->count() == 0) {
            return ['status' => false, 'msg' => 'Self-Appraisal Not Filled for this ACR '];
        }

        return ['status' => true, 'msg' => ''];
    }

    public function permissionForPdf()
    {
        $user=Auth::user();

        if ($user->hasPermissionTo(['acr-special']) || ($user->employee_id == $this->employee_id)) {
            return true;
        }

        if($user->employee_id==$this->report_employee_id && (!$this->report_on)){
            return true;
        }

        if($user->employee_id==$this->review_employee_id && (!$this->review_on)){
            return true;
        }

        if($user->employee_id==$this->accept_employee_id && (!$this->accept_on)){
            return true;
        }
        return false;
    }

}
